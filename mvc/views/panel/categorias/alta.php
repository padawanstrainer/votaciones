<h2>Nueva categoria</h2>
<form method="post" action="/panel/categorias/crear">
    <div>
        <span>Categoria</span>
        <input type="text" name="categoria" />
    </div>
    <div>
        <span>Ceremonia</span>
        <select name="ceremonia">
            <?php foreach($ceremonias as $c){
                echo "<option value='$c[ID]'>$c[NOMBRE]</option>";
            }?>
        </select>
    </div>
    <div>
        <button type="submit">Crear</button>
        <button type="button" onclick="location.href='/panel/categorias';">Cancelar</button>
    </div>
</form>