<h2>Editar ceremonia</h2>

<form method="post" action="/panel/ceremonias/<?php echo $id; ?>/actualizar">
    <div>
        <span>Ceremonia</span>
        <input type="text" name="nombre" value="<?php echo $ceremonia['NOMBRE']; ?>" />
    </div>
    <div>
        <span>Inicio nominaciones</span>
        <input type="date" name="nominaciones_inicio" value="<?php echo $ceremonia['FECHA_NOMINACIONES_INICIO']; ?>" />
    </div>
    <div>
        <span>Fin nominaciones</span>
        <input type="date" name="nominaciones_fin" value="<?php echo $ceremonia['FECHA_NOMINACIONES_FIN']; ?>" />
    </div>
    <div>
        <span>Inicio votaciones</span>
        <input type="date" name="votaciones_inicio" value="<?php echo $ceremonia['FECHA_VOTACIONES_INICIO']; ?>" />
    </div>
    <div>
        <span>Inicio votaciones</span>
        <input type="date" name="votaciones_fin" value="<?php echo $ceremonia['FECHA_VOTACIONES_FIN']; ?>" />
    </div>
    <div>
        <span>Resultados visibles</span>
        <input type="datetime-local" name="resultados_visibles" value="<?php echo $ceremonia['FECHA_RESULTADOS_VISIBLES']; ?>" />
    </div>
    <div>
        <input type="checkbox" name="actual" id="actual" value="1" <?php echo $ceremonia[ 'CEREMONIA_ACTUAL' ] == '1' ? 'checked' : ''; ?> />
        <label for="actual">Ceremonia actual</label>
    </div>
    <div>
        <button type="submit">Guardar cambios</button>
        <button type="button" onclick="location.href='/panel/ceremonias';">Cancelar</button>
    </div>
</form>