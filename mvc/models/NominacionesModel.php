<?php 
class NominacionesModel{
    public static function agregar( $candidato, $imagen, $fkcategoria ){
        global $cnx;
        $fkusuario = $_SESSION['USER']['ID'];
        $consulta = "INSERT INTO nominaciones SET NOMINADO = ?, IMAGEN = ?, ACTIVO = 1, FECHA_ALTA = NOW( ), FKUSUARIO = ?, FKCATEGORIA = ?, UUID = UUID_SHORT( )";
        $stmt = $cnx->prepare($consulta);
        $stmt->execute( [ $candidato, $imagen, $fkusuario, $fkcategoria ] );
    }
}