<h2>Ya has votado</h2>
<p class='subtitle'>Estas son las opciones que elegiste a la hora de emitir tu voto para los CastorAwards 2022.<br />
Te recordamos que la ceremonía de premiaciones tendrá lugar el día <?php echo $ceremonia_actual['FECHA_CEREMONIA_SPA']; ?></p>
<section class="section-votaciones">
    <?php 
    foreach( $datos['nominados'] as $idcategoria => $categoria ):
        echo "<div>";
        echo "<h3>$categoria[categoria]</h3>";
        echo "<ul>";
        foreach( $categoria['opciones'] as $opcion ){
            $icono_votado = $opcion['seleccionado'] == 1 ? ' <span>&lArr; elegiste este</span>' : '';
            $class_seleccionado = $opcion['seleccionado'] == 1 ? 'seleccionado' : 'no-seleccionado';
            $img_tag = $opcion["foto"] ? 
                        "<div><img src='/assets/uploads/$opcion[foto]' alt='Imagen de  $opcion[nombre]' /></div>" :
                        "";
    
            echo "<li class='$class_seleccionado'>$opcion[nombre]$icono_votado $img_tag</li>";
        }
        echo "</ul>";
        echo "</div>";
    endforeach;
    ?>

</section>