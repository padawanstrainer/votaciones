<section>
    <?php 
    if($datos['already_voted']):
        include( 'votar_resultados.php');
    else:
        include( 'votar_form.php' );
    endif;
    ?>
</section>