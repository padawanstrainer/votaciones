<section>
    <?php 
    foreach( $datos['nominados'] as $idcategoria => $categoria ):
        echo "<div>";
        echo "<h3>$categoria[categoria]</h3>";
        foreach( $categoria['opciones'] as $opcion ){
            $icono_votado = $opcion['seleccionado'] == 1 ? 'SI' : 'NO';
            echo "<div><span>$icono_votado</span> $opcion[nombre]</div>";
        }
        echo "</div>";
    endforeach;
    ?>

</section>