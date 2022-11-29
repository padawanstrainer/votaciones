<?php 
require 'config/php/setup.php';
require 'config/php/autoload.php';
require 'config/php/funciones.php';

$recursos = UtilsController::get_view( $categoria, $accion );
$vista = $recursos['tpl'];
$class = $recursos['class'];

if(
    ! is_null($subaccion) &&
    AuthController::isAdmin() &&
    in_array($subaccion, [ 'crear', 'actualizar', 'eliminar' ])
){
    $metodo_admin = $accion.'_'.$subaccion;
    $datos_metodo = $_SERVER['REQUEST_METHOD'] == 'POST' ? 
                    $_POST :
                    $_GET;

    if( isset($_GET['id'] ) ){
        $datos_metodo['id'] = $_GET['id'];
    }

    var_dump($datos_metodo);

    AdminController::$metodo_admin( $datos_metodo );
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
    <link rel="stylesheet" href="/assets/estilos.css" />
    <title>CastorAwards</title>
</head>
<body>
    <header>
        <h1>CastorAwards</h1>
        <nav>
            <ul>
                <li><a href='/'>Home</a></li>
                <!-- este link en particular, va a cambiar según el contexto -->
                <?php if( AuthController::isLogged( ) ): ?>
                    <li><a href='/postular'>Postular</a></li>
                    <li><a href='/votar'>Votar</a></li>
                <?php else: ?>
                    <li><a href='/login'>Login</a></li>
                <?php endif; ?>
                <!-- este link es solo para el admin -->
                <?php if( AuthController::isAdmin( ) ): ?>
                    <li><a href='/panel'>Panel de control</a></li>
                <?php endif; ?>
                <?php if( AuthController::isLogged( ) ): ?>
                    <li><a href='/logout'>Salir</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <?php include "mvc/views/$vista"; ?>
    </main>
</body>
</html>