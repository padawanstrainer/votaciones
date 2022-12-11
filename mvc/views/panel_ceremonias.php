<?php 
$sub_accion = $_GET['subaccion'] ?? 'listado';

switch( $sub_accion ){
    case 'alta':
        include( MVC.'/views/panel/ceremonias/alta.php');
    break;
    case 'editar':
        $id = $_GET['id'] ?? 0;
        $ceremonia = CeremoniasModel::find( $id );

        include( MVC.'/views/panel/ceremonias/editar.php');
    break;
    case 'listado':
        include( MVC.'/views/panel/ceremonias/listado.php');
    break;
}
?>