<?php

namespace Classes;

use Resend;

class Email {

    public $email;
    public $nombre;
    public $token;
    
    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {  
        $resend = Resend::client($_ENV['RESEND_API_KEY']);

        try {
            $result = $resend->emails->send([
                'from' => 'Pelis',
                'to' => [$this->email],
                'subject' => 'Hello world',
                'html' => '<strong>It works!</strong>',
            ]);
        } catch (\Exception $e) {
            exit('Error: ' . $e->getMessage());
        }
        
        // Show the response of the sent email to be saved in a log...
        echo $result->toJson();
    }

    public function enviarInstrucciones() {
        $from = 'cuentas@devwebcamp.com';
        $to = $this->email;
        $subject = 'Reestablece tu password';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre .  "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['HOST'] . "/recuperar?token=" . $this->token . "'>Reestablecer Password</a></p>";        
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= '</html>';

    }
}
