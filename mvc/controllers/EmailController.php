<?php 
//TODO: Revisar sendgrid, mailgun, mailtrap servicios de email... 
class EmailController{

    private static function parseTemplate( $template, $datos ){
        $file = MVC.DS.'views'.DS.'emails'.DS.$template;
        $datos['DOMINIO'] = UtilsController::getBaseUrl( );
        $mail_body = '';
        if(file_exists($file)){
            $mail_body = file_get_contents($file);
            foreach ($datos as $clave => $valor) {
                $mail_body = str_replace( '{{'.$clave.'}}', $valor, $mail_body ); 
            }
        }
        $contenido = file_get_contents(MVC.DS.'views'.DS.'emails'.DS.'base.html');
        $contenido = str_replace( '{{MAIL_BODY}}', $mail_body, $contenido ); 
        $contenido = str_replace( '{{DOMINIO}}', $datos['DOMINIO'], $contenido ); 
        return $contenido;
    }

    public static function send( $params = [] ){
        $mail_body = self::parseTemplate($params['cuerpo'], $params['valores']);

        echo $mail_body;
        //var_dump($params);
        die( );
    }
}