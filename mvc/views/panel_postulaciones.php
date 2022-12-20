<section>
<?php 
$subaccion =  $_GET['subaccion'] ?? 'listado';

switch( $subaccion ){
    case 'editar':
        $id = $_GET['id'] ?? 0;
        $ceremonia = NominacionesModel::find( $id );

        include( MVC.'/views/panel/postulaciones/editar.php');
    break;
    case 'listado':
        include( MVC.'/views/panel/postulaciones/listado.php');
    break;
}
?>
</section>