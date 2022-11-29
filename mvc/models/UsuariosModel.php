<?php 
class UsuariosModel{
    public static function find( $email, $clave ){
        global $cnx;
        $consulta = "SELECT * FROM usuarios WHERE EMAIL=? AND CLAVE= SHA1( ? ) LIMIT 1";
        $stmt = $cnx->prepare( $consulta );
        $stmt->execute( [ $email, $clave ] );
        $resultado = $stmt->fetch( );

        return $resultado;
    }

    public static function all( ){
        global $cnx;
        $consulta = "SELECT * FROM usuarios";
        $stmt = $cnx->prepare( $consulta );
        $stmt->execute( );
        $users = $stmt->fetchAll( );

        return $users;
    }
}