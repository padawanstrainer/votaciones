<?php 
require_once MVC.DS.'models'.DS.'VotosModel.php';

class VoteController{
    public static function index( ){
        $id_usuario = isset( $_SESSION['USER'] ) ? 
                            $_SESSION['USER']['ID'] :
                            0;
        $total_votos = VotosModel::can_vote( $id_usuario );
        $nominados = VotosModel::votaciones( $id_usuario );
        
        return [
            'already_voted' => (int) $total_votos['TOTAL'] > 0,
            'nominados' => $nominados
        ];
    }

    public static function save( $datos ){
        foreach($datos as $d){
            VotosModel::insert( $d, $_SESSION['USER']['ID'] );
        }
        die( header("Location: /votar") );
    }
}