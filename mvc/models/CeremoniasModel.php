<?php 

class CeremoniasModel{
    public static function all( ){
        global $cnx;
        $c = <<<SQL
        SELECT 
            *, 
            DATE_FORMAT( FECHA_NOMINACIONES_FIN, '%d/%m/%Y' ) AS NOMINACIONES_INICIO,
            DATE_FORMAT( FECHA_NOMINACIONES_INICIO, '%d/%m/%Y' ) AS NOMINACIONES_FIN,
            DATE_FORMAT( FECHA_VOTACIONES_INICIO, '%d/%m/%Y' ) AS VOTACIONES_INICIO,
            DATE_FORMAT( FECHA_VOTACIONES_FIN, '%d/%m/%Y' ) AS VOTACIONES_FIN,
            DATE_FORMAT( FECHA_RESULTADOS_VISIBLES, '%d/%m/%Y' ) AS RESULTADOS_VISIBLES,
            IF( CEREMONIA_ACTUAL = 1, 'actual', '---' ) AS ACTUAL
        FROM ceremonias
        SQL;
        $st = $cnx->prepare($c);
        $st->execute( );
        return $st->fetchAll( );
    }

    public static function find( $id ){
        global $cnx;
        $c = <<<SQL
        SELECT
            ID,
            NOMBRE,
            CEREMONIA_ACTUAL,
            DATE(FECHA_NOMINACIONES_INICIO) AS FECHA_NOMINACIONES_INICIO,
            DATE(FECHA_NOMINACIONES_FIN) AS FECHA_NOMINACIONES_FIN,
            DATE(FECHA_VOTACIONES_INICIO) AS FECHA_VOTACIONES_INICIO,
            DATE(FECHA_VOTACIONES_FIN) AS FECHA_VOTACIONES_FIN,
            FECHA_RESULTADOS_VISIBLES
        FROM ceremonias
        WHERE ID = ?
        LIMIT 1
        SQL;
        $st = $cnx->prepare($c);
        $st->execute( [ $id ] );
        return $st->fetch( );
    }

    public static function getCurrentCeremony( ){
        global $cnx;
        $query = <<<SQL
        SELECT 
            NOMBRE,
            FECHA_NOMINACIONES_INICIO,
            FECHA_NOMINACIONES_FIN,
            FECHA_VOTACIONES_INICIO,
            FECHA_VOTACIONES_FIN,
            FECHA_RESULTADOS_VISIBLES,
            NOW( ) AS HOY,
            IF( NOW( ) BETWEEN FECHA_NOMINACIONES_INICIO AND FECHA_NOMINACIONES_FIN, 1, 0 ) AS NOMINACIONES_ACTIVAS,
            IF( NOW( ) BETWEEN FECHA_VOTACIONES_INICIO AND FECHA_VOTACIONES_FIN, 1, 0 ) AS VOTACIONES_ACTIVAS,
            IF( NOW( ) > FECHA_RESULTADOS_VISIBLES, 1, 0) AS VER_RESULTADOS
        FROM ceremonias
        WHERE CEREMONIA_ACTUAL = 1
SQL;
        $stmt = $cnx->prepare( $query );
        $stmt->execute( );
        return $stmt->fetch( );
    }

    public static function insert( $d ){
        global $cnx;
        $c = <<<SQL
            INSERT INTO ceremonias
            SET 
                NOMBRE = ?,
                FECHA_NOMINACIONES_INICIO = ?,
                FECHA_NOMINACIONES_FIN = ?,
                FECHA_VOTACIONES_INICIO = ?,
                FECHA_VOTACIONES_FIN = ?,
                FECHA_RESULTADOS_VISIBLES = ?,
                CEREMONIA_ACTUAL = ?
        SQL;
        $st = $cnx->prepare( $c );
        $st->execute( [
            $d['nombre'],
            $d['nominaciones_inicio'],
            $d['nominaciones_fin'],
            $d['votaciones_inicio'],
            $d['votaciones_fin'],
            $d['resultados_visibles'],
            $d['actual'] ?? 0
        ] );
    }

    public static function update( $d ){
        global $cnx;
        $c = <<<SQL
            UPDATE ceremonias
            SET 
                NOMBRE = ?,
                FECHA_NOMINACIONES_INICIO = ?,
                FECHA_NOMINACIONES_FIN = ?,
                FECHA_VOTACIONES_INICIO = ?,
                FECHA_VOTACIONES_FIN = ?,
                FECHA_RESULTADOS_VISIBLES = ?,
                CEREMONIA_ACTUAL = ?
            WHERE ID = ? 
            LIMIT 1
        SQL;
        $st = $cnx->prepare( $c );
        $st->execute( [
            $d['nombre'],
            $d['nominaciones_inicio'],
            $d['nominaciones_fin'],
            $d['votaciones_inicio'],
            $d['votaciones_fin'],
            $d['resultados_visibles'],
            $d['actual'] ?? 0,
            $d['id']
        ] );
    }

    public static function delete( $id ){

    }

    
    public static function removeActual( $id ){
        global $cnx;
        $c = "UPDATE ceremonias SET CEREMONIA_ACTUAL = 0 WHERE CEREMONIA_ACTUAL = 1 AND ID != ?";

        $st = $cnx->prepare($c);
        $st->execute( [ $id ] );
    }

}