<?php 
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
                $template = 'postular.php';
                $clase = 'VoteController';
            break;
            case 'votar':
                $template = 'votar.php';
                $clase = 'VoteController';
            break;
            case 'panel':
                $clase = 'AdminController';
                if( ! AuthController::isAdmin( ) ):
                    $template = 'forbidden.php';
                else:
                    switch( $metodo ):
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
}