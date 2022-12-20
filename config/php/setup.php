<?php 
session_start( );

date_default_timezone_set("America/Argentina/Buenos_Aires");
$dsn = "mysql:host=localhost;charset=utf8mb4;dbname=castawards";
$usuario = 'root';
$clave = '';

define( 'DS', DIRECTORY_SEPARATOR );
define( 'DEV', true );
define( 'ROOT', dirname(__DIR__, 2) );
define( 'MVC', ROOT.DS.'mvc' );
define( 'IMG_WIDTH', 200 );
 
try{ 
    $cnx = new PDO( $dsn, $usuario, $clave, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ] );
}catch( PDOException $e ){
    die('Error en la conexión de la base de datos '.$e->getMessage() );
}

$categoria = $_GET['cat'] ?? 'home'; 
$accion = $_GET['accion'] ?? 'index';
$subaccion = $_GET['subaccion'] ?? NULL;

$headerClass = $categoria == 'home' ? 'big' : 'collapsed';