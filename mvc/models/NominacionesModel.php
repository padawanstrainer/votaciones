<?php 
class NominacionesModel{
    public static function agregar( $candidato, $imagen, $fkcategoria ){
        global $cnx;
        $fkusuario = $_SESSION['USER']['ID'];
        $consulta = "INSERT INTO nominaciones SET NOMINADO = ?, IMAGEN = ?, ACTIVO = 1, FECHA_ALTA = NOW( ), FKUSUARIO = ?, FKCATEGORIA = ?, UUID = UUID_SHORT( )";
        $stmt = $cnx->prepare($consulta);
        $stmt->execute( [ $candidato, $imagen, $fkusuario, $fkcategoria ] );
    }

    public static function all( ){
        global $cnx;
        $c = <<<SQL
        SELECT 
            n.ID,
            n.IMAGEN,
            n.NOMINADO,
            IFNULL(n.ACTIVO, 2) AS ACTIVO,
            n.FECHA_ALTA,
            u.EMAIL,
            c.CATEGORIA,
            cer.NOMBRE AS CEREMONIA
        FROM 
            nominaciones AS n 
            JOIN categorias AS c ON c.ID = n.FKCATEGORIA
            JOIN usuarios AS u ON u.ID = n.FKUSUARIO
            JOIN ceremonias AS cer ON cer.ID = c.FKCEREMONIA
        WHERE 
            cer.CEREMONIA_ACTUAL = 1
        ORDER BY 
            ACTIVO DESC,
            c.ORDEN,
            n.FKCATEGORIA,
            n.NOMINADO
        SQL;
        $st = $cnx->prepare($c);
        $st->execute( );
        return $st->fetchAll( );
    }

    public static function activar( $id, $estado ){
        global $cnx;
        $c = "UPDATE nominaciones SET ACTIVO = ? WHERE ID = ? LIMIT 1";
        $s = $cnx->prepare($c);
        $s->execute( [ $estado, $id ] );
    }

    public static function find( $id ){
        global $cnx;
        $c = "SELECT * FROM nominaciones WHERE ID = ? LIMIT 1";
        $st = $cnx->prepare($c);
        $st->execute([$id]);
        return $st->fetch( );
    }

    public static function update( $datos ){
        global $cnx;
        $parametros = [
            $datos['nombre'],
            $datos['estado'] == 2 ? NULL : $datos['estado'],
            $datos['id']
        ];

        $str_imagen = '';
        if( ! is_null( $datos['imagen'] ) ){
            $str_imagen = "IMAGEN = ?,";
            array_unshift($parametros, $datos['imagen']);
        }

        $c = <<<SQL
            UPDATE
                nominaciones
            SET
                $str_imagen
                NOMINADO = ?,
                ACTIVO = ?
            WHERE ID = ?
            LIMIT 1
        SQL;

        $st = $cnx->prepare($c);
        $st->execute( $parametros );

    }

    public static function removeImage( $id ){
        global $cnx;
        $c = "UPDATE nominaciones SET IMAGEN = NULL WHERE ID = ?";
        $s = $cnx->prepare($c);
        $s->execute( [ $id ] );
    }
}