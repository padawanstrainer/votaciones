<form method="post" action="/votaciones">
    <?php 
    foreach( $datos['nominados'] as $idcategoria => $categoria ):
        echo "<fieldset>";
        echo "<legend>$categoria[categoria]</legend>";
        foreach( $categoria['opciones'] as $opcion ){
            $name = 'votacion_'.$idcategoria;
            echo "<div><label><input type='radio' value='$opcion[uuid]' name='$name' />$opcion[nombre]</label></div>";
        }
        echo "</fieldset>";
    endforeach;
    ?>

<button type="submit">Guardar</button>
</form>