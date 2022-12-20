<?php 
$id = $datos['ceremonia']['ID'];
?>
<h2>Ordenar categorias</h2>
<p class='subtitle'>Redefinir el orden con el que se mostrarán las categorias de la ceremonia <?php echo $datos['ceremonia']['NOMBRE']; ?> durante la votación</p>

<form method="post" action="/panel/ceremonias/<?php echo $id; ?>/orden" class='ordenar-categorias'>
    <?php 
    foreach( $datos['categorias'] as $c ){
        echo <<<HTML
        <div>
            <span>$c[CATEGORIA]</span>
            <button type="button" class="up">&uArr;</button>
            <button type="button" class="down">&dArr;</button>
            <input type="hidden" name="orden[]" value="$c[ID]" />
        </div>
        HTML;
    }
    ?>
    <div class='botones'>
        <button type="submit">Guardar</button>
    </div>
</form>
<script src="/assets/js/dom.js"></script>
<script>
    const D = new DOM( );
    const btn_up = D.queryAll('.up');
    const btn_down = D.queryAll('.down');
    Array.from( btn_up ).forEach( btn => {
        btn.addEventListener('click', e => {
            const div = e.target.parentNode;
            const divAnterior = div.previousElementSibling;
            if( divAnterior == null ) return;

            divAnterior.parentNode.insertBefore( div, divAnterior );
        } );
    } );
    Array.from( btn_down ).forEach( btn => {
        btn.addEventListener('click', e => {
            const div = e.target.parentNode;
            const divSiguiente = div.nextElementSibling;
            if( divSiguiente == null || divSiguiente.className == 'botones' ) return;

            divSiguiente.parentNode.insertBefore( divSiguiente, div );

        } );
    } );
</script>