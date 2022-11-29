<h2>Editar categoria</h2>

<form method="post" action="/panel/categorias/<?php echo $id; ?>/actualizar">
    <div>
        <span>Categoria</span>
        <input type="text" name="categoria" value="<?php echo $categoria['CATEGORIA']; ?>" />
    </div>
    <div>
        <span>Ceremonia</span>
        <select name="ceremonia">
            <?php foreach($ceremonias as $c){
                $selected = $c['ID'] == $categoria['FKCEREMONIA'] ? 'selected' : '';
                echo "<option value='$c[ID]' $selected>$c[NOMBRE]</option>";
            }?>
        </select>
    </div>
    <div>
        <button type="submit">Guardar cambios</button>
        <button type="button" onclick="location.href='/panel/categorias';">Cancelar</button>
    </div>
</form>