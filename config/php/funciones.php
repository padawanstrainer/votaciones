<?php 
function getSqlError( $st ){
    $errores = $st->errorInfo();
    $error = $errores[2];
    $error_message = NULL;
    switch( true ){
        case preg_match("/a foreign key constraint fails/", $error ):
            $error_message = "No se ha podido realizar la acción, por un error de integridad de claves";
        break;
    }
    return $error_message;
}

function showError( ){
    if( isset($_SESSION['ERROR'] ) ):
        echo "<p class='error'>$_SESSION[ERROR]</p>";
        unset( $_SESSION['ERROR'] );
    endif;
}