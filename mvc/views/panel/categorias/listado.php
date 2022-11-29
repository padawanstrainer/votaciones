<h2>Listado de categorias</h2>
<a href='/panel/categorias/alta'>NUEVA CATEGORIA</a>

<?php include(MVC.'/views/botonera_admin.php' ); ?>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>CATEGORIA</th>
            <th>ORDEN</th>
            <th>CEREMONIA</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($datos['categorias'] as $c): 
        echo <<<HTML
        <tr>
            <td>$c[CATEGORIA]</td>
            <td>$c[ORDEN]</td>
            <td>$c[CEREMONIA]</td>
            <td>
                <a href='/panel/categorias/$c[ID]/editar'>EDITAR</a>
                <a href='/panel/categorias/$c[ID]/eliminar'>ELIMINAR</a>
            </td>
        </tr>
        HTML;
        endforeach; ?>
    </tbody>  
</table>