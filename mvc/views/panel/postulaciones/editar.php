<h2>Editar nominación</h2>

<form method="post" action="/panel/postulaciones/<?php echo $id; ?>/actualizar" enctype="multipart/form-data">
    <div>
        <span>Nombre</span>
        <input type="text" name="nombre" value="<?php echo $ceremonia['NOMINADO']; ?>"  required />
    </div>
    <div>
        <span>Estado</span>
        <select name="estado">
            <option <?php echo $ceremonia['ACTIVO'] == 1 ? 'selected': ''; ?> value="1">Aceptado</option>
            <option  <?php echo $ceremonia['ACTIVO'] == 0 ? 'selected': ''; ?> value="0">Rechazado</option>
            <option  <?php echo ! in_array( $ceremonia['ACTIVO'], [ '0', '1'] ) ? 'selected': ''; ?>  value="2">Pendiente</option>
        </select>
    </div>
    <div>
        <span>Imagen</span>
        <div class='input-column'>
            <input type="file" name="imagen" accept="image/*" />

            <?php if( ! is_null( $ceremonia['IMAGEN'] ) ){
                echo "<img src='/assets/uploads/$ceremonia[IMAGEN]' height='100' />";
                echo "<input type='checkbox' id='borrar_foto' name='borrar_foto' value='1' /><label for='borrar_foto'>Eliminar imagen</label>";
            } ?>
        </div>
    </div>
    <div>
        <button type="submit">Guardar cambios</button>
        <button type="button" onclick="location.href='/panel/postulaciones';">Cancelar</button>
    </div>
</form>