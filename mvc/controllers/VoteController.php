<?php 
require_once MVC.DS.'models'.DS.'VotosModel.php';

class VoteController{
    public static function index( ){
        $total_votos = VotosModel::can_vote( $_SESSION['USER']['ID'] );

        $nominados = VotosModel::votaciones( $_SESSION['USER']['ID'] );
        
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