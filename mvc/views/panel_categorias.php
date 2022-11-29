<?php 
require MVC.'/models/CeremoniasModel.php';

$sub_accion = $_GET['subaccion'] ?? 'listado';

switch( $sub_accion ){
    case 'alta':
        $ceremonias = CeremoniasModel::all( );
        include( MVC.'/views/panel/categorias/alta.php');
    break;
    case 'editar':
        $id = $_GET['id'] ?? 0;
        $ceremonias = CeremoniasModel::all( );
        $categoria = CategoriasModel::find( $id );

        include( MVC.'/views/panel/categorias/editar.php');
    break;
    case 'listado':
        include( MVC.'/views/panel/categorias/listado.php');
    break;
}
?>