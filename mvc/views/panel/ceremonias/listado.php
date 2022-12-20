<h2>Listado de ceremonias</h2>

<div class="sub-botonera">
    <a href='/panel/ceremonias/alta' class='alta'>NUEVA CEREMONIA</a>
    <?php include(MVC.'/views/botonera_admin.php' ); ?>
</div>
<?php showError(); ?>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th rowspan="2">Ceremonia</th>
            <th rowspan="2">Fecha</th>
            <th colspan="2">Nominaciones</th>
            <th colspan="2">Votaciones</th>
            <th>Resultados</th>
            <th rowspan="2">Actual</th>
            <th rowspan="2">Cant. Cat.</th>
            <th rowspan="2">Acciones</th>
        </tr>
        <tr>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Visibilidad</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($datos['ceremonias'] as $c): 

        $btn_borrar = $c['CANT_CATEGORIAS'] == 0 ?
                        "<a class='btn_borrar' href='/panel/ceremonias/$c[ID]/eliminar'>ELIMINAR</a>":
                        "";
        $btn_ordenar = $c['CANT_CATEGORIAS'] > 1 ?
                        "<a href='/panel/ceremonias/$c[ID]/ordenar'>ORDENAR</a>":
                        "";
        echo <<<HTML
        <tr>
            <td>$c[NOMBRE]</td>
            <td>$c[FECHA_CEREMONIA]</td>
            <td>$c[NOMINACIONES_INICIO]</td>
            <td>$c[NOMINACIONES_FIN]</td>
            <td>$c[VOTACIONES_INICIO]</td>
            <td>$c[VOTACIONES_FIN]</td>
            <td>$c[RESULTADOS_VISIBLES]</td>
            <td>$c[ACTUAL]</td>
            <td>$c[CANT_CATEGORIAS]</td>
            <td>
                <a href='/panel/ceremonias/$c[ID]/editar'>EDITAR</a>
                $btn_borrar
                $btn_ordenar
            </td>
        </tr>
        HTML;
        endforeach; ?>
    </tbody>  
</table>
<script src="/assets/js/dom.js"></script>
<script>
    const D = new DOM( );
    const btns_borrar = D.queryAll('.btn_borrar');
    Array.from(btns_borrar).forEach( btn => {
        btn.addEventListener('click', e => {
            const rta = confirm('Esta segurx que quiere borrar la ceremonia?\nEsta acción es irreversible');
            if( ! rta ) e.preventDefault( );
        } );
    } );
</script>