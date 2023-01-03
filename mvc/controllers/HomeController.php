<?php 
class HomeController{
    public static function index( ){
        $categorias = CategoriasModel::getGrid( );
        return ['ternas' => $categorias ];
    }
}