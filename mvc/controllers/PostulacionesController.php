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

    public static function uploadFile( $file ){
        $path = ROOT.DS.'assets'.DS.'uploads';
        if( ! is_dir( $path ) ) mkdir( $path );

        switch( true ){
            case preg_match( "/jpe?g$/i", $file['type'] ):
                $original = imagecreatefromjpeg($file['tmp_name']);
            break;
            case preg_match( "/png$/i", $file['type'] ):
                $original = imagecreatefrompng($file['tmp_name']);
            break;
            case preg_match( "/webp$/i", $file['type'] ):
                $original = imagecreatefromwebp($file['tmp_name']);
            break;
            default: 
                return NULL;
            break;
        }

        $ancho_o = imagesx($original);
        $alto_o = imagesy($original);

        $ancho_c = IMG_WIDTH;
        $alto_c = round( $ancho_c * $alto_o / $ancho_o ); 

        $nombre_foto = sha1( $file['tmp_name'] ).'.png';
        $copia = imagecreatetruecolor($ancho_c, $alto_c);
        imagecopyresampled(
            $copia,
            $original,
            0, 0,
            0, 0,
            $ancho_c, $alto_c,
            $ancho_o, $alto_o
        );
        imagepng( $copia, $path.DS.$nombre_foto );
        return $nombre_foto;
    }

    public static function deletePrevImage( $id ){
        $anterior = NominacionesModel::find( $id );
        $archivo = $anterior['IMAGEN'];
        if(
            !empty($archivo) 
            && file_exists(ROOT.DS.'assets'.DS.'uploads'.DS.$archivo)
            && !is_dir(ROOT.DS.'assets'.DS.'uploads'.DS.$archivo)
        ){
            unlink(ROOT.DS.'assets'.DS.'uploads'.DS.$archivo);
        }
        NominacionesModel::removeImage($id);
    }
}