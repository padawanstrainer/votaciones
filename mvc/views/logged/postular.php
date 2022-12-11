<h2>Agregá candidatos a las categorías del CastorAwards</h2>

<form method="post" action="/postulaciones">
    <button type="button" id="agregar_candidato">Otro candidato más</button>
    <button type="submit">Enviar postulaciones</button>
</form>
<script src='/assets/js/dom.js'></script>
<script>
    const categorias = <?php echo json_encode( $datos['categorias'] ); ?>;
</script>
<script src='/assets/js/postular.js'></script>
<?php 

//var_dump($datos); ?>