<?php 

class CategoriasModel{
    public static function all( $array = [] ){
        global $cnx;

        $where = isset($array['where']) ?  "WHERE $array[where]" : '';
        $order = $array['order'] ?? 'CEREMONIA_ACTUAL DESC, FKCEREMONIA DESC, ORDEN ASC';
        $vars = $array['vars'] ?? NULL;

        $consulta = "SELECT cat.ID, cat.CATEGORIA, cat.ORDEN, cer.NOMBRE as CEREMONIA FROM categorias AS cat JOIN ceremonias AS cer ON cer.ID = cat.FKCEREMONIA $where ORDER BY $order";

        $stmt = $cnx->prepare( $consulta );
        $stmt->execute( $vars );
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
        $c = <<<SQL
        INSERT INTO categorias 
        SET 
            CATEGORIA=?,
            ORDEN=(
                SELECT IFNULL( MAX(c.ORDEN), -1) + 1 
                FROM categorias AS c
                WHERE c.FKCEREMONIA = ? 
            ), 
            FKCEREMONIA=?
        SQL;
        $stmt = $cnx->prepare( $c );
        $stmt->execute( [ $datos['categoria'], $datos['ceremonia'], $datos['ceremonia'] ] );
    }

    public static function update( $datos ){
        global $cnx;
        $c = "UPDATE categorias SET CATEGORIA=?, FKCEREMONIA=? WHERE ID = ? LIMIT 1";
        $stmt = $cnx->prepare( $c );
        $stmt->execute( [ $datos['categoria'], $datos['ceremonia'], $datos['id'] ] );
    }

    public static function delete( $id ){
        global $cnx;
        $c1 = "SELECT FKCEREMONIA FROM categorias WHERE ID = ? LIMIT 1";
        $stmt = $cnx->prepare( $c1 );
        $stmt->execute( [ $id ] );
        $datos = $stmt->fetch( );
        $id_ceremonia = $datos['FKCEREMONIA'];


        $c = "DELETE FROM categorias WHERE ID= ? LIMIT 1";
        $stmt = $cnx->prepare( $c );
        $stmt->execute( [ $id ] );

        //NECESITO REORDENAR LOS NUMERITOS DEL ORDEN
        $c2 = "SELECT ID FROM categorias WHERE FKCEREMONIA = ? ORDER BY ORDEN";
        $stmt = $cnx->prepare( $c2 );
        $stmt->execute( [ $id_ceremonia ] );
        $categorias = $stmt->fetchAll( );
        foreach($categorias as $orden => $cat ){
            CeremoniasModel::reordenar( $orden, $cat['ID'], $id_ceremonia );
        }
    }

    public static function getActuales( ){
        global $cnx;
        $c = "SELECT cat.ID, CATEGORIA FROM categorias AS cat JOIN ceremonias AS cer ON cer.ID = cat.FKCEREMONIA WHERE cer.CEREMONIA_ACTUAL=1 ORDER BY ORDEN";
        $s = $cnx->prepare($c);
        $s->execute( );
        return $s->fetchAll( );
    }
}