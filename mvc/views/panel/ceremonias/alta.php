<h2>Crear ceremonia</h2>

<form method="post" action="/panel/ceremonias/crear">
    <div>
        <span>Ceremonia</span>
        <input type="text" name="nombre" required autocomplete="off" />
    </div>
    <div>
        <span>Inicio nominaciones</span>
        <input type="date" name="nominaciones_inicio" />
    </div>
    <div>
        <span>Fin nominaciones</span>
        <input type="date" name="nominaciones_fin"  />
    </div>
    <div>
        <span>Inicio votaciones</span>
        <input type="date" name="votaciones_inicio" />
    </div>
    <div>
        <span>Inicio votaciones</span>
        <input type="date" name="votaciones_fin"  />
    </div>
    <div>
        <span>Resultados visibles</span>
        <input type="datetime-local" name="resultados_visibles"  />
    </div>
    <div>
        <input type="checkbox" name="actual" id="actual" value="1" />
        <label for="actual">Ceremonia actual</label>
    </div>
    <div>
        <button type="submit">Guardar cambios</button>
        <button type="button" onclick="location.href='/panel/ceremonias';">Cancelar</button>
    </div>
</form>