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
        UsuariosModel::find( $data['usuario'], $data['clave'] );
        #var_dump($data);
die( );
        #die( header("Location: /") );
    }

    public static function login( $data ){
        $user = UsuariosModel::find( $data['usuario'], $data['clave'] );
        if( ! $user ){
            $_SESSION['inputs_login'] = $data;
            $_SESSION['error_login'] = "Usuario o clave incorrecto";
            die( header("Location: /login") );
        }
        if( $user['ACTIVO'] == 0 ){
            $_SESSION['error_login'] = "Cuenta inhabilitada, contacte al admin :)";
            die( header("Location: /login") );
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