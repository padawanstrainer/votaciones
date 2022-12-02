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
            'ADMIN' => $user['ES_ADMIN']
        ];

        die( header("Location: /") );
    }


    public static function isLogged( ){
        return isset( $_SESSION['USER'] ) ;
    }

    public static function isAdmin( ){
        return  isset( $_SESSION['USER'] ) &&
                $_SESSION['USER']['ADMIN'] == 1;
    }
}