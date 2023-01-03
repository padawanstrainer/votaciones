<section>
    <h2>Detalles de la ceremonia</h2>
    <ul class="ceremonia-detalles">
        <li><?php echo $ceremonia['NOMBRE']; ?></li>
        <li>Fecha: <?php echo $ceremonia['FECHA_CEREMONIA_SPA']; ?></li>
        <li><?php echo $ceremonia['CANT_NOMINADOS']; ?> nominados</li>
        <li><?php echo $ceremonia['CANT_VOTANTES']; ?> votantes únicos</li>
    </ul>
    <?php 
    echo '<ul class="ganadores">';
    foreach( $votaciones as $v ){
        $imagen = !is_null( $v['IMAGEN'] ) ? "<img src='/assets/uploads/$v[IMAGEN]'>" : '';
        echo <<<HTML
            <li>
                $imagen
                <p>
                    <b>$v[CATEGORIA]</b>
                    <span>$v[NOMINADO] ($v[TOTAL] votos de $v[VOTOS_TOTALES] / $v[PORCENTAJE]%)</span>
                </p>
            </li>
        HTML;
    }
    echo '</ul>';
    ?>
</section>