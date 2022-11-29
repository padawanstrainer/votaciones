<?php 

class CeremoniasModel{
    public static function all( ){
        global $cnx;
        $c = "SELECT * FROM ceremonias";
        $st = $cnx->prepare($c);
        $st->execute( );
        return $st->fetchAll( );
    }
}