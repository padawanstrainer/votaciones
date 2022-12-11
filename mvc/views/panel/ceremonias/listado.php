<h2>Listado de ceremonias</h2>
<a href='/panel/ceremonias/alta'>NUEVA CEREMONIA</a>

<?php include(MVC.'/views/botonera_admin.php' ); ?>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th rowspan="2">CEREMONIA</th>
            <th colspan="2">NOMINACIONES</th>
            <th colspan="2">VOTACIONES</th>
            <th>RESULTADOS</th>
            <th rowspan="2">ACTUAL</th>
            <th rowspan="2">ACCIONES</th>
        </tr>
        <tr>
            <th>FECHA INICIO</th>
            <th>FECHA FIN</th>
            <th>FECHA INICIO</th>
            <th>FECHA FIN </th>
            <th>VISIBILIDAD</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($datos['ceremonias'] as $c): 
        echo <<<HTML
        <tr>
            <td>$c[NOMBRE]</td>
            <td>$c[NOMINACIONES_INICIO]</td>
            <td>$c[NOMINACIONES_FIN]</td>
            <td>$c[VOTACIONES_INICIO]</td>
            <td>$c[VOTACIONES_FIN]</td>
            <td>$c[RESULTADOS_VISIBLES]</td>
            <td>$c[ACTUAL]</td>
            <td>
                <a href='/panel/ceremonias/$c[ID]/editar'>EDITAR</a>
                <a href='/panel/ceremonias/$c[ID]/eliminar'>ELIMINAR</a>
            </td>
        </tr>
        HTML;
        endforeach; ?>
    </tbody>  
</table>