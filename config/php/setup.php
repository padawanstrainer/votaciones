<?php 
session_start( );

$hostname = $_SERVER['HTTP_HOST'];
$port = $_SERVER['SERVER_PORT'];
$hostname = str_replace(":$port", "", $hostname);

if( preg_match("/^www\./i", $hostname ) ){
    $hostname = preg_replace("/^www\./i", "", $hostname);
}

//ACA YA BORRE EL PUERTO :7501 y EL WWW => WWW.MISITIO.COM -> MISITIO.COM
$path = dirname( __FILE__, 3 );
$archivo_ini = $path.'/'.$hostname.'.ini';
$archivo_ini_default = $path.'/localhost.ini';

if( ! file_exists($archivo_ini) ){
    if(! file_exists($archivo_ini_default) ){
        die( 'Falta el archivo de configuración localhost.ini o '.$hostname.'.ini' );
    }

    $archivo_ini = $archivo_ini_default;
}


$config = parse_ini_file( $archivo_ini, true );

ini_set('display_errors', $config['config']['error'] );
date_default_timezone_set($config['config']['tz']);

$db = $config['db'];

$dsn = "mysql:host=$db[host];charset=$db[charset];dbname=$db[db];port=$db[port]";


define( 'DS', DIRECTORY_SEPARATOR );
define( 'DEV', $config['config']['dev'] );
define( 'ROOT', dirname(__DIR__, 2) );
define( 'MVC', ROOT.DS.'mvc' );
define( 'IMG_WIDTH', 200 );
 
try{ 
    $cnx = new PDO( $dsn, $db['user'], $db['pass'], [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ] );
}catch( PDOException $e ){
    die('Error en la conexión de la base de datos '.$e->getMessage() );
}

$categoria = $_GET['cat'] ?? 'home'; 
$accion = $_GET['accion'] ?? 'index';
$subaccion = $_GET['subaccion'] ?? NULL;

$headerClass = $categoria == 'home' ? 'big' : 'collapsed';