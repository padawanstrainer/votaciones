<?php 

class VotosModel{
    public static function can_vote( $id ){
        global $cnx;
        $c = <<<SQL
        SELECT COUNT( * ) AS TOTAL
        FROM votos AS v 
        WHERE FKUSUARIO = ?
        SQL;

        $s = $cnx->prepare($c);
        $s->execute( [ $id ] );
        return $s->fetch( );
    }

    public static function votaciones( $id ){
        global $cnx;
        $c = <<<SQL
            SELECT 
                cer.NOMBRE AS CEREMONIA,
                cat.ID AS IDCATEGORIA,
                cat.CATEGORIA,
                n.ID as IDNOMINADO,
                n.NOMINADO,
                n.IMAGEN,
                n.UUID,
                IFNULL( ( SELECT IF( FKNOMINACION IS NULL, 0, 1 ) FROM votos WHERE FKNOMINACION = n.ID AND FKUSUARIO = ? ), 0 ) AS SELECCIONADO
            FROM categorias AS cat
            JOIN ceremonias AS cer ON cer.ID = cat.FKCEREMONIA
            JOIN nominaciones AS n ON cat.ID = n.FKCATEGORIA
            WHERE cer.CEREMONIA_ACTUAL = 1 AND n.ACTIVO = 1
            ORDER BY cat.ORDEN, cat.ID, n.NOMINADO
        SQL;
        $st = $cnx->prepare($c);
        $st->execute( [ $id ] );
        $resultados = $st->fetchAll();

        $respuesta = [];
        foreach( $resultados as $r ){
            $idcategoria = $r['IDCATEGORIA'];
            if( !isset( $respuesta[$idcategoria] ) ):
                $respuesta[$idcategoria] = [
                    'categoria' => $r['CATEGORIA'],
                    'opciones' => []
                ];
            endif;


            //ACA EXISTE $respuesta[$idcategoria]['opciones']
            $respuesta[$idcategoria]['opciones'][] = [
                'id' => $r['IDNOMINADO'],
                'nombre' => $r['NOMINADO'],
                'foto' => $r['IMAGEN'],
                'uuid' => $r['UUID'],
                'seleccionado' => $r['SELECCIONADO']
            ];

        }
        return $respuesta;
    }

    public static function insert( $idvoto, $idusuario ){
        global $cnx;
        $c = "INSERT INTO votos SET FKUSUARIO = ?, FKNOMINACION = ( SELECT ID FROM nominaciones WHERE UUID = ? LIMIT 1 )";
        $s = $cnx->prepare($c);
        $s->execute( [$idusuario, $idvoto] );
    }
}