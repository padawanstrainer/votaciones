<section>
    <h2>Postulación de candidatos</h2>
    <p class='subtitle'>Postulá a los candidatos que consideres apropiados para cada una de las ternas.<br />
    Luego, nuestro comité de evaluación de nominados, seleccionará los que correspondan en cada categoría</p>

    <form method="post" action="/postulaciones" class='form-postulaciones'>
        <div id="generated-inputs"></div>
        <div class='buttons'>
            <button type="button" id="agregar_candidato">Otro candidato más</button>
            <button type="submit">Enviar postulaciones</button>
        </div>
    </form>
</section>

<script src='/assets/js/dom.js'></script>
<script>
    const categorias = <?php echo json_encode( $datos['categorias'] ); ?>;
</script>
<script src='/assets/js/postular.js'></script>