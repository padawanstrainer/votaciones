<?php 
$estados = [
    'rechazado', //0
    'aceptado', //1
    'pendiente' //2
];
?>
<h2>Auditar postulaciones</h2>

<div class="sub-botonera">
    <?php include(MVC.'/views/botonera_admin.php' ); ?>
</div>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Nominación</th>
            <th>Categoria</th>
            <th>Ceremonia</th>
            <th>Usuario</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    foreach( $datos['nominaciones'] as $n ):
    $activo = $estados[ $n['ACTIVO'] ];

    $btn_aceptar = $n['ACTIVO'] == 1 ? '' : "<a href='/panel/postulaciones/$n[ID]/crear'>Aceptar</a>";
    $btn_rechazar = $n['ACTIVO'] == 0 ? '' : "<a href='/panel/postulaciones/$n[ID]/eliminar'>Rechazar</a>";

    $img_tag = '-';
    if( ! is_null( $n['IMAGEN'] ) ){
        $img_tag = "<img src='/assets/uploads/$n[IMAGEN]' alt='$n[NOMINADO]' height='30' />";
    }

    echo <<<HTML
        <tr class='estado_$activo'>
            <td>$img_tag</td>
            <td>$n[NOMINADO]</td>
            <td>$n[CATEGORIA]</td>
            <td>$n[CEREMONIA]</td>
            <td>$n[EMAIL]</td>
            <td>$activo</td>
            <td>
                <a href='/panel/postulaciones/$n[ID]/editar'>Editar</a>
                $btn_aceptar
                $btn_rechazar
            </td>
        </tr>
    HTML;
    endforeach;
    ?>
    </tbody>
</table>