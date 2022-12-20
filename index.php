<?php 
require 'config/php/setup.php';
require 'config/php/autoload.php';
require 'config/php/funciones.php';

$ceremonia_actual = UtilsController::getCurrentCeremony( );
$recursos = UtilsController::get_view( $categoria, $accion );
$vista = $recursos['tpl'];
$class = $recursos['class'];

if(
    ! is_null($subaccion) &&
    AuthController::isAdmin() &&
    ( 
        in_array($subaccion, [ 'crear', 'actualizar', 'eliminar'])
        || ( $subaccion == 'ordenar' && $accion == 'ceremonias' )
        || ( $subaccion == 'orden' && $accion == 'ceremonias' &&  $_SERVER['REQUEST_METHOD'] == 'POST' )
    )
){

    $metodo_admin = $accion.'_'.$subaccion;
    $datos_metodo = $_SERVER['REQUEST_METHOD'] == 'POST' ? 
                    $_POST :
                    $_GET;

    if( isset($_GET['id'] ) ){
        $datos_metodo['id'] = $_GET['id'];
    }

    $datos =AdminController::$metodo_admin( $datos_metodo );
    $datos =AdminController::$metodo_admin( $datos_metodo );
}else if( ! method_exists( $class, $accion ) ){
    $vista = '404.php';
    $datos = [];
}else {
    $datos = $class::$accion( );
}

?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/fonts/stylesheet.css">
    <link rel="stylesheet" href="/assets/css/estilos.css">
    <?php 
    if( $categoria == 'panel' ){
    echo '<link rel="stylesheet" href="/assets/css/panel.css">';
    }
    ?>
    <title>CastorAwards</title>
</head>
<body>
    <div class='<?php echo $headerClass; ?> fakin-border-bottom-for-the-header'>
        <header>
            <h1>Castor Awards</h1>
            <span>Premios a la Excelencia Twitchera</span>
            <nav>
                <ul>
                    <li><a href='/'>Home</a></li>
                    <!-- este link en particular, va a cambiar según el contexto -->
                    <?php if( AuthController::isLogged( ) ): 
                        if( $ceremonia_actual['NOMINACIONES_ACTIVAS'] == 1 ){
                    ?>
                        <li><a href='/postular'>Postular</a></li>
                    <?php 
                        }

                        if( $ceremonia_actual['VOTACIONES_ACTIVAS'] == 1 ){
                    ?>
                        <li><a href='/votar'>Votar</a></li>
                    <?php 
                        };
                        else: ?>
                        <li><a href='/login'>Login</a></li>
                    <?php endif; ?>
                    <!-- este link es solo para el admin -->
                    <?php if( AuthController::isAdmin( ) ): ?>
                        <li><a href='/panel'>Panel de control</a></li>
                    <?php endif; ?>
                    <?php if( AuthController::isLogged( ) ): ?>
                        <li><a href='/logout'>Salir (<?php echo $_SESSION['USER']['USERNAME']; ?>)</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </header>
    </div>
    <main class='container'>
        <?php include "mvc/views/$vista"; ?>
    </main>
    <footer>
        <p>Copyright 2022, todos los derechos reservados<br />
            Los CastorAwards son una idea de Germán Rodríguez<br />
            Los premios de esta ceremonia son solo nominales</p>
        <p>Los datos de registros y login no se usarná para ninguna otra finalidad más que garantizar el acceso a la plataforma</p>
    </footer>
</body>
</html>