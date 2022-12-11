<?php 
class UsuariosModel{
    public static function find( $email, $clave ){
        global $cnx;
        $consulta = "SELECT ID, ES_ADMIN, ACTIVO, SUBSTRING_INDEX( EMAIL, '@', 1 ) AS USERNAME FROM usuarios WHERE EMAIL=? AND CLAVE= SHA1( ? ) LIMIT 1";
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
        $consulta = "SELECT *, DATE_FORMAT( FECHA_ALTA, '%d/%m/%Y %H:%ihs' ) AS FECHA_SPA, IF(ES_ADMIN=1, 'Admin', 'User') AS NIVEL, IF(ACTIVO=1,'Activo','Banneado') as ESTADO FROM usuarios ORDER BY ES_ADMIN DESC, ACTIVO DESC, EMAIL";
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

    public static function bannear( $id, $estado ){
        global $cnx;
        $c = "UPDATE usuarios SET ACTIVO = ? WHERE ID = ? LIMIT 1";
        $s = $cnx->prepare($c);
        $s->execute( [ $estado, $id ] );
    }
}