<?php 
require_once MVC.DS.'models'.DS.'CategoriasModel.php';
require_once MVC.DS.'models'.DS.'NominacionesModel.php';

class PostulacionesController{
    public static function index( ){
        $categorias = CategoriasModel::getActuales( );

        return [
            'categorias' => $categorias
        ] ;
    }

    public static function postular( $datos ){
        foreach( $datos['candidato'] as $indice => $candidato ){
            foreach( $datos['categorias'][$indice] as $idcategoria ){
                NominacionesModel::agregar($candidato, NULL, $idcategoria);
            }
        }
        die( header("Location: /postular") );
    }
}