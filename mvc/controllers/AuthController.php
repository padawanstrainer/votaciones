<?php 
include_once MVC.'/models/UsuariosModel.php';

class AuthController{
    //ver el php de registro o login
    public static function index( ){
        return [ ];
    }

    public static function logout( ){
        session_start( );
        session_destroy( );
        header("Location: /");
    }

    public static function register( $data ){
        $email = $data['usuario'];
        $rta = UsuariosModel::check( $email );
        if( $rta ){ //el usuario ya existía, wacho... redirect con mensaje de error
            UtilsController::redirectWithMessage("/login", [
                'error_register' => 'Usuario ya registrado'
            ] );
        }
        //si llegué acá, es porque el usuario aún no existe... vamos a crearlo...
        $clave = UtilsController::generateRandomPassword( );

        $respuesta = UsuariosModel::register($email, sha1($clave));
        if( ! $respuesta ){
            UtilsController::redirectWithMessage("/login", [
                'error_register' => 'Hubo un error registrando el usuario'
            ] );
        }

        //MANDAR EL MAIL A LA CUENTA DEL USUARIO
        $email_params = [
            'destinatario' => $email,
            'asunto' => 'Se ha creado tu cuenta!',
            'cuerpo' => 'registro.html',
            'valores' => [
                'USUARIO' => $email,
                'CLAVE' => $clave
            ]
        ];
        EmailController::send( $email_params );

        UtilsController::redirectWithMessage("/login", [
            'success_register' => 'Usuario registrado con éxito, ya se puede loguear'
        ] );
    }

    public static function login( $data ){
        $user = UsuariosModel::find( $data['usuario'], $data['clave'] );
        if( ! $user ){
            UtilsController::redirectWithMessage("/login", [
                'error_login' => 'Usuario o clave incorrecto',
                'inputs_login' => $data
            ] );
        }

        if( $user['ACTIVO'] == 0 ){
            UtilsController::redirectWithMessage("/login", [
                'error_login' => 'Cuenta inhabilitada, contacte al admin :)'
            ] );
        }

        $_SESSION['USER'] = [
            'ID' => $user['ID'],
            'ADMIN' => $user['ES_ADMIN'],
            'USERNAME' => $user['USERNAME']
        ];

        die( header("Location: /") );
    }

    public static function retrieve( $data ){
        global $cnx;
        $email = $data['email'] ?? null;

        //1. Ver si me llegó bien la petición con el email
        if( is_null($email) ){
            echo json_encode([ "status" => false, "msg" => "No se recibieron los datos necesarios" ]);
            die( );
        }

        //2. Ver que el email esté dado de alta en la BdD y que esté el user activo
        $consulta = "SELECT ID FROM usuarios WHERE EMAIL = ? AND ACTIVO = 1 LIMIT 1";
        $stmt = $cnx->prepare($consulta);
        $stmt->execute([$email]);

        $datos = $stmt->fetch();
        if( !$datos ){
            echo json_encode([ "status" => false, "msg" => "Usuario inexistente o cuenta deshabilitada, contacte al administrador" ]);
            die( );
        }

        $idUsuario = $datos['ID'];
        //3. Verificar que no tenga una petición pendiente dentro del tiempo de espera... XX minutos
        $cooldown = 5; //minutos de cooldown
        $consulta2 = "SELECT IF( TIMESTAMPDIFF( MINUTE, FECHA_ALTA, NOW( ) ) < ?, 0, 1) AS HABILITADO FROM recuperar_claves WHERE FKUSUARIO = ? LIMIT 1";
        $stmt = $cnx->prepare($consulta2);
        $stmt->execute([ $cooldown, $idUsuario ]);
        $pendiente = $stmt->fetch( );

        $enabled = $pendiente['HABILITADO'] ?? 1;
        if( ! $enabled ){
            echo json_encode([ "status" => false, "msg" => "No podés pedir otra contraseña dentro del plazo de $cooldown min" ]);
            die( );
        }

        //4. Genero los datos nuevos de esta petición
        $claveNueva = UtilsController::generateRandomPassword( );
        $fecha = date('Y-m-d H:i:s');
        $token = sha1( $fecha.$idUsuario.sha1($claveNueva) );
        $usuario = strrev(sha1( $idUsuario )); 

        //5. Guardo esos datos en la tabla de recuperar_claves
        $consulta3 = "INSERT INTO recuperar_claves SET FKUSUARIO = ?,  FECHA_ALTA = ?, NUEVA_CLAVE = ? ON DUPLICATE KEY UPDATE FECHA_ALTA = ?, NUEVA_CLAVE = ?";
        $stmt = $cnx->prepare($consulta3);
        $stmt->execute([$idUsuario, $fecha, sha1($claveNueva), $fecha, sha1($claveNueva)]);

        //6. Abro el template del mail y le mando los parametros de reemplazo
        $email_params = [
            'destinatario' => $email,
            'asunto' => 'Recuperar contraseña de los CA',
            'cuerpo' => 'recuperar.html',
            'valores' => [
                'TOKEN' => $token,
                'USUARIO' => $usuario,
                'CLAVE' => $claveNueva
            ]
        ];
        EmailController::send( $email_params );

        $rta = [ "status" => false, "msg" => "Usuario inexistente", 'token' => $token ];
        echo json_encode($rta);
        die( );
    }

    public static function confirmar_clave( $get ){
        global $cnx;
        if( ! isset($get['u']) || ! isset($get['t'] ) ){
            UtilsController::redirectWithMessage("/login", [
                'error_login' => 'Faltan credenciales'
            ] );
            die( );
        }

        if(
            ! preg_match( "/^[0-9a-f]{40}$/", $get['u']) ||
            ! preg_match( "/^[0-9a-f]{40}$/", $get['t']) 
        ){
            UtilsController::redirectWithMessage("/login", [
                'error_login' => 'Credenciales adulteradas'
            ] );
            die( );
        }

        $u = $get['u'];
        $t = $get['t'];

        $consulta = "SELECT FKUSUARIO, NUEVA_CLAVE, TIMESTAMPDIFF( MINUTE, FECHA_ALTA, NOW() ) AS DIFERENCIA FROM recuperar_claves WHERE SHA1( CONCAT( FECHA_ALTA, FKUSUARIO, NUEVA_CLAVE) ) = ? AND REVERSE(SHA1( FKUSUARIO )) = ? LIMIT 1";
        $stmt = $cnx->prepare($consulta);
        $stmt->execute( [ $t, $u ] );
        $datos = $stmt->fetch( );

        if( 
            $datos === false || 
            ( is_array($datos) && $datos['DIFERENCIA'] > 120 ) 
        ){
            UtilsController::redirectWithMessage("/login", [
                'error_login' => 'No hay transacciones pendientes para el token solicitado, o ha expirado'
            ] );
            die( );
        }

        $consulta4 = "UPDATE usuarios SET CLAVE = ? WHERE ID = ? LIMIT 1";
        $stmt = $cnx->prepare($consulta4);
        $stmt->execute([ $datos['NUEVA_CLAVE'], $datos['FKUSUARIO'] ]);

        $consulta5 = "DELETE FROM recuperar_claves WHERE FKUSUARIO = ? LIMIT 1";
        $stmt = $cnx->prepare($consulta5);
        $stmt->execute([ $datos['FKUSUARIO'] ]);
        UtilsController::redirectWithMessage("/login", [
            'ok_login' => 'Ya podés acceder con tu nueva clave! :)'
        ] );
        die( );
    }

    public static function isLogged( ){
        return isset( $_SESSION['USER'] ) ;
    }

    public static function isAdmin( ){
        return  isset( $_SESSION['USER'] ) &&
                $_SESSION['USER']['ADMIN'] == 1;
    }
}