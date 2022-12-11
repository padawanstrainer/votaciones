<h2>Listado de usuarios</h2>
<?php include MVC.'/views/botonera_admin.php'; ?>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Email</th>
            <th>Fecha alta</th>
            <th>Nivel</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach( $datos['usuarios'] as $u ):
            $class_nivel = 'estado_'.strtolower($u['NIVEL']).'_'.strtolower($u['ESTADO']);

            $btn_bannear = $u['ACTIVO'] == 0 ? '' : "<a href='/panel/usuarios/$u[ID]/eliminar'>Bannear</a>";
            $btn_desbannear = $u['ACTIVO'] == 1 ? '' : "<a href='/panel/usuarios/$u[ID]/crear'>Desbannear</a>";

            echo <<<HTML
            <tr class='$class_nivel'>
                <td>$u[EMAIL]</td>
                <td>$u[FECHA_SPA]</td>
                <td>$u[NIVEL]</td>
                <td>$u[ESTADO]</td>
                <td>
                    $btn_bannear
                    $btn_desbannear
                </td>
            </tr>
            HTML;
        endforeach
        ?>
    </tbody>
</table>