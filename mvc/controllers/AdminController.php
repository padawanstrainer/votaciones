<?php 
include_once MVC . '/models/CategoriasModel.php';
include_once MVC . '/models/UsuariosModel.php';

class AdminController{
    public static function index( ){

    }

    public static function ceremonias( ){
        $ceremonias = CeremoniasModel::all( );
        return [ 'ceremonias' => $ceremonias ];
    }

    public static function ceremonias_crear( $datos ){
        $es_actual = (bool) ( $datos['actual'] ?? 0 );
        if( $es_actual ) CeremoniasModel::removeActual( 0 );
        CeremoniasModel::insert( $datos );
        die( header( "Location: /panel/ceremonias" ) );
    }

    public static function ceremonias_actualizar( $datos ){
        $es_actual = (bool) ( $datos['actual'] ?? 0 );
        if( $es_actual ) CeremoniasModel::removeActual( $datos['id'] );
        CeremoniasModel::update( $datos );
        die( header( "Location: /panel/ceremonias" ) );
    }

    public static function ceremonias_eliminar( $get ){
        $id = $get['id'] ?? 0;
        $rta = CeremoniasModel::delete( $id );
        if( $rta['error'] ){
            $_SESSION['ERROR'] = $rta['msg'];
        }
        die( header( "Location: /panel/ceremonias" ) );
    }

    public static function ceremonias_ordenar( $get ){
        $id = $get['id'] ?? 0;
        $ceremonia = CeremoniasModel::find( $id );
        if( ! $ceremonia ){
            $_SESSION['ERROR'] = 'Ceremonia inexistente';
            die( header( "Location: /panel/ceremonias" ) );
        }
        if( $ceremonia['CANT_CATEGORIAS'] < 2 ){
            $_SESSION['ERROR'] = 'La ceremonia no tiene suficientes categorias';
            die( header( "Location: /panel/ceremonias" ) );
        }

        $categorias = CategoriasModel::all( [
            'where' => "FKCEREMONIA = ?",
            'order' => "ORDEN ASC, CATEGORIA ASC",
            'vars' => [ $id ]
        ] );
        $datos = [ 'ceremonia' => $ceremonia, 'categorias' => $categorias ];
        return $datos;
    }


    public static function ceremonias_orden( $post ){
        $id_ceremonia = $post['id'];
        foreach( $post['orden'] as $orden => $id_categoria ){
            CeremoniasModel::reordenar( $orden, $id_categoria, $id_ceremonia );
        }

        die( header( "Location: /panel/ceremonias" ) );
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

    public static function postulaciones( ){
        $nominaciones = NominacionesModel::all( );
        return [ 'nominaciones' => $nominaciones ];
    }

    public static function postulaciones_crear( $datos ){
        NominacionesModel::activar( $datos['id'], 1 );
        die( header( "Location: /panel/postulaciones" ) );
    }

    public static function postulaciones_eliminar( $datos ){
        NominacionesModel::activar( $datos['id'], 0 );
        die( header( "Location: /panel/postulaciones" ) );
    }

    public static function postulaciones_actualizar( $datos ){
        $tengo_imagen =  $_FILES['imagen']['size'] > 0;

        //solo borro la foto anterior, si tengo una nueva O si quiero borrar_anterior
        if( $tengo_imagen || isset($datos['borrar_foto'] ) ){
            PostulacionesController::deletePrevImage($datos['id']);
        }

        //despues de borrar, veo si necesito subir una nueva
        if($tengo_imagen){
            $datos['imagen'] = PostulacionesController::uploadFile($_FILES['imagen']);
        }

        NominacionesModel::update( $datos );
        die( header( "Location: /panel/postulaciones" ) );
    }

    public static function usuarios( ){
        $usuarios = UsuariosModel::all( );
        return [ 'usuarios' => $usuarios ];
    }

    public static function usuarios_eliminar( $datos ){
        UsuariosModel::bannear( $datos['id'], 0 );
        die( header( "Location: /panel/usuarios" ) );
    }

    public static function usuarios_crear( $datos ){
        UsuariosModel::bannear( $datos['id'], 1 );
        die( header( "Location: /panel/usuarios" ) );
    }
}