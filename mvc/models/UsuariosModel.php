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

    public static function check( $email ){
        global $cnx;
        $consulta = "SELECT ID FROM usuarios WHERE EMAIL=? LIMIT 1";
        $stmt = $cnx->prepare( $consulta );
        $stmt->execute( [ $email ] );
        $resultado = $stmt->fetch( );

        return (bool) $resultado;
    }

    public static function all( ){
        global $cnx;
        $consulta = "SELECT * FROM usuarios";
        $stmt = $cnx->prepare( $consulta );
        $stmt->execute( );
        $users = $stmt->fetchAll( );

        return $users;
    }

    public static function register( $email, $clave ){
        global $cnx;
        $consulta = "INSERT INTO usuarios SET EMAIL=?, CLAVE=?, FECHA_ALTA=NOW( )";
        $stmt = $cnx->prepare( $consulta );
        $rta = $stmt->execute( [ $email, $clave ] );

        return $rta;
    }
}