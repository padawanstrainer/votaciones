<?php 

class CategoriasModel{
    public static function all( ){
        global $cnx;
        $consulta = "SELECT cat.ID, cat.CATEGORIA, cat.ORDEN, cer.NOMBRE as CEREMONIA FROM categorias AS cat JOIN ceremonias AS cer ON cer.ID = cat.FKCEREMONIA ORDER BY CEREMONIA_ACTUAL DESC, FKCEREMONIA DESC, ORDEN ASC";
        $stmt = $cnx->prepare( $consulta );
        $stmt->execute( );
        $categorias = $stmt->fetchAll( );

        return $categorias;
    }

    public static function find( $id ){
        global $cnx;
        $c = "SELECT * FROM categorias WHERE ID= ? LIMIT 1";
        $s = $cnx->prepare($c);
        $s->execute( [ $id ] );
        return $s->fetch( );
    }

    public static function insert( $datos ){
        global $cnx;
        $c = "INSERT INTO categorias SET CATEGORIA=?, ORDEN=1, FKCEREMONIA=?";
        $stmt = $cnx->prepare( $c );
        $stmt->execute( [ $datos['categoria'], $datos['ceremonia'] ] );
    }

    public static function update( $datos ){
        global $cnx;
        $c = "UPDATE categorias SET CATEGORIA=?, FKCEREMONIA=? WHERE ID = ? LIMIT 1";
        $stmt = $cnx->prepare( $c );
        $stmt->execute( [ $datos['categoria'], $datos['ceremonia'], $datos['id'] ] );
    }

    public static function delete( $id ){
        global $cnx;
        $c = "DELETE FROM categorias WHERE ID= ? LIMIT 1";
        $stmt = $cnx->prepare( $c );
        $stmt->execute( [ $id ] );
    }

    public static function getActuales( ){
        global $cnx;
        $c = "SELECT cat.ID, CATEGORIA FROM categorias AS cat JOIN ceremonias AS cer ON cer.ID = cat.FKCEREMONIA WHERE cer.CEREMONIA_ACTUAL=1 ORDER BY ORDEN";
        $s = $cnx->prepare($c);
        $s->execute( );
        return $s->fetchAll( );
    }
}