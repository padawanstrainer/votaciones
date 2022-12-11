<?php 
include_once MVC.DS.'models'.DS.'CeremoniasModel.php';

class UtilsController{
    public static function get_view( $ruta, $metodo ){
        $template = '404.php';
        $clase = null;

        switch($ruta):
            case 'home': 
                $template = 'landing.php';
                $clase = 'HomeController'; 
            break;
            case 'login':
                $template = 'login.php';
                $clase = 'AuthController';
            break;
            case 'postular': 
                $clase = 'PostulacionesController';
                if( ! AuthController::isLogged() ):
                    $template = 'forbidden.php';
                else: 
                    $template = 'logged/postular.php';
                endif;
            break;
            case 'postulaciones':
                if( ! AuthController::isLogged() ):
                    die( header("Location: /") );
                else: 
                    self::postRequired( );
                    PostulacionesController::postular( $_POST );
                endif;
            break;
            case 'votar':
                $clase = 'VoteController';
                if( ! AuthController::isLogged() ):
                    $template = 'forbidden.php';
                else: 
                    $template = 'logged/votar.php';
                endif;
            break;
            case 'votaciones':
                if( ! AuthController::isLogged() ):
                    die( header("Location: /") );
                else: 
                    self::postRequired( );
                    VoteController::save( $_POST );
                endif;
            break;
            case 'panel':
                $clase = 'AdminController';
                if( ! AuthController::isAdmin( ) ):
                    $template = 'forbidden.php';
                else:
                    switch( $metodo ):
                        case 'ceremonias':
                            $template = 'panel_ceremonias.php';
                        break;
                        case 'categorias':
                            $template = 'panel_categorias.php';
                        break;
                        case 'usuarios':
                            $template = 'panel_usuarios.php';
                        break;
                        case 'postulaciones':
                            $template = 'panel_postulaciones.php';
                        break;
                        default: $template = 'panel.php';
                    endswitch;
                endif;
            break;
            case 'auth':
                switch( $metodo ){
                    case 'register':
                        self::checkReferer( );
                        self::postRequired( );
                        AuthController::register( $_POST );
                    break;
                    case 'login':
                        self::checkReferer( );
                        self::postRequired( );
                        AuthController::login( $_POST );
                    break;
                }
            break;
            case 'logout':
                AuthController::logout( );
            break;
        endswitch;

        return ['tpl' => $template, 'class' => $clase ];
    }

    public static function checkReferer( ){
        $referer = $_SERVER['HTTP_REFERER'] ?? NULL;
        $host = $_SERVER['HTTP_HOST'];
        $er = "#^https?://$host#";

        if( ! preg_match( $er, $referer ) ){
            die( header("Location: /") );
        }
    }

    public static function postRequired( ){
        if($_SERVER['REQUEST_METHOD'] != 'POST' ){
            die( header("Location: /") );
        }
    }

    public static function redirectWithMessage( $url, $session = [ ] ){
        foreach( $session as $key => $value ){
            $_SESSION[$key] = $value;
        }
        die( header("Location: $url") );
    }


    public static function generateRandomPassword( $length = 8 ){
        $caracteres = str_split("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789%&$=!@#_-+");
        $pwd = '';
        for( $i = 0; $i < $length; $i++ ){
            $pwd .= $caracteres[ array_rand($caracteres) ];
        }
        return $pwd;
    }


    public static function getBaseUrl( ){
        return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];
    }

    public static function getCurrentCeremony( ){
        return CeremoniasModel::getCurrentCeremony( );
    }
}