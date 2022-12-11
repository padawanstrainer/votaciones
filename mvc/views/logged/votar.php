<h2>Votar</h2>

<?php 

if($datos['already_voted']):
    include( 'votar_resultados.php');
else:
    include( 'votar_form.php' );
endif;
?>