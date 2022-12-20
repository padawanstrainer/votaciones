<h2>Votaciones abiertas</h2>
<p class='subtitle'>Seleccioná los ganadores de cada una de las ternas para la ceremonia de los CastorAwards.<br />
Tené presente que solo podrás votar UNA VEZ en las categorías. Una vez emitido tu voto, no lo podrás cambiar</p>

<form method="post" action="/votaciones" class='form-votaciones'>
    <?php 
    foreach( $datos['nominados'] as $idcategoria => $categoria ):
        echo "<fieldset>";
        echo "<legend>$categoria[categoria]</legend>";
        foreach( $categoria['opciones'] as $opcion ){
            $name = 'votacion_'.$idcategoria;
            $img_tag = $opcion["foto"] ? 
                        "<img src='/assets/uploads/$opcion[foto]' alt='Imagen de  $opcion[nombre]' />" : 
                        "";

            echo <<<HTML
            <div>
                <input type='radio' id='radio_$opcion[uuid]' value='$opcion[uuid]' name='$name' />
                <label for='radio_$opcion[uuid]'>
                    $opcion[nombre]
                    $img_tag
                </label>
            </div>
            HTML;
        }
        echo "</fieldset>";
    endforeach;
    ?>
    <div class='buttons'>
        <button type="submit">Guardar</button>
    </div>
</form>