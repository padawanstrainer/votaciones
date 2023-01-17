<?php 
require( dirname(__FILE__, 3). '/config/php/setup.php' );

if( ! isset( $_SESSION['USER'] ) ){
    echo json_encode( [
        'status' => false,
        'msg' => 'Sesión expirada'
    ] );
     die( );
}


$id_usuario = $_SESSION['USER']['ID'];
$clave = trim( $_POST['clave'] );
if( empty($clave) ){
    echo json_encode( [
        'status' => false,
        'msg' => 'Eh, culiao, dame tuuuu clave'
    ] );
     die( );
}

$clave = sha1( $clave );

$consulta = "UPDATE usuarios SET CLAVE = ? WHERE ID = ? LIMIT 1";
$stmt = $cnx->prepare( $consulta );
$stmt->execute( [ $clave, $id_usuario ] );

echo json_encode([
    'status' => true
]);