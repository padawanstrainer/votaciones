<?php 
include_once MVC . '/models/CategoriasModel.php';
include_once MVC . '/models/UsuariosModel.php';

class AdminController{
    public static function index( ){

    }

    public static function categorias( ){
        $categorias = CategoriasModel::all( );
        return [ 'categorias' => $categorias ];
    }

    public static function categorias_crear( $datos ){
        CategoriasModel::insert( $datos );
        die( header( "Location: /panel/categorias" ) );
    }

    public static function categorias_actualizar( $datos ){
        CategoriasModel::update( $datos );
        die( header( "Location: /panel/categorias" ) );
    }

    public static function categorias_eliminar( $get ){
        $id = $get['id'] ?? 0;
        CategoriasModel::delete( $id );
        die( header( "Location: /panel/categorias" ) );
    }

    public static function usuarios( ){
        $usuarios = UsuariosModel::all( );
        return [ 'usuarios' => $usuarios ];
    }
}