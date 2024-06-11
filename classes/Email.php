<?php

namespace Classes;

use Exception;
use GuzzleHttp\Client;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;
use Brevo\Client\Api\TransactionalEmailsApi;

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
        // Desactivar la verificación de SSL para cURL
        $configa = [
            'verify' => false
        ];

        $contenido = '<html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .email-container {
                    background-color: #ffffff;
                    padding: 20px;
                    margin: 20px auto;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    max-width: 600px;
                }
                .email-header {
                    font-size: 24px;
                    color: #333333;
                    margin-bottom: 20px;
                }
                .email-content {
                    font-size: 16px;
                    color: #555555;
                }
                .email-content a {
                    color: #3498db;
                    text-decoration: none;
                }
                .email-content a:hover {
                    text-decoration: underline;
                }
                .email-footer {
                    font-size: 14px;
                    color: #999999;
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-header">
                    Hola ' . $this->nombre . ',
                </div>
                <div class="email-content">
                    <p>Has registrado correctamente tu cuenta en Pelis; pero es necesario confirmarla.</p>
                    <p>Presiona aquí: <a href="' . $_ENV['HOST'] . '/auth/confirmar-cuenta?token=' . $this->token . '">Confirmar Cuenta</a></p>
                    <p>Si tú no creaste esta cuenta, puedes ignorar este mensaje.</p>
                </div>
                <div class="email-footer">
                    &copy; ' . date('Y') . ' Pelis. Todos los derechos reservados.
                </div>
            </div>
        </body>
        </html>';        

        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $_ENV['CLIENT_PASS_EMAIL']);
        $apiInstance = new TransactionalEmailsApi(new Client($configa), $config);
        
        $sendSmtpEmail = new SendSmtpEmail([
            'subject' => 'Mensaje Confirmación Pelis',
            'sender' => ['name' => 'Pelis', 'email' => $this->email],
            'to' => [['name' => $this->nombre, 'email' => $this->email]],
            'htmlContent' => $contenido 
        ]);
        
        try {
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (Exception) {
            header('Location: /auth/registro');
        }
    }

    public function enviarInstrucciones() {
        // Desactivar la verificación de SSL para cURL
        $configa = [
            'verify' => false
        ];
    
        $contenido = '<html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .email-container {
                    background-color: #ffffff;
                    padding: 20px;
                    margin: 20px auto;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    max-width: 600px;
                }
                .email-header {
                    font-size: 24px;
                    color: #333333;
                    margin-bottom: 20px;
                }
                .email-content {
                    font-size: 16px;
                    color: #555555;
                }
                .email-content a {
                    color: #3498db;
                    text-decoration: none;
                }
                .email-content a:hover {
                    text-decoration: underline;
                }
                .email-footer {
                    font-size: 14px;
                    color: #999999;
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-header">
                    Hola ' . $this->nombre . ',
                </div>
                <div class="email-content">
                    <p>Has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo.</p>
                    <p>Presiona aquí: <a href="' . $_ENV['HOST'] . '/auth/reestablecer?token=' . $this->token . '">Reestablecer Password</a></p>
                    <p>Si tú no solicitaste este cambio, puedes ignorar este mensaje.</p>
                </div>
                <div class="email-footer">
                    &copy; ' . date('Y') . ' Pelis. Todos los derechos reservados.
                </div>
            </div>
        </body>
        </html>';
    
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $_ENV['CLIENT_PASS_EMAIL']);
        $apiInstance = new TransactionalEmailsApi(new Client($configa), $config);
        
        $sendSmtpEmail = new SendSmtpEmail([
            'subject' => 'Mensaje Confirmación Pelis',
            'sender' => ['name' => 'Pelis', 'email' => 'no-reply@pelis.com'],
            'to' => [['name' => $this->nombre, 'email' => $this->email]],
            'htmlContent' => $contenido 
        ]);
        
        try {
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (Exception $e) {
            header('Location: /auth/registro');
            exit();
        }
    }
    
}