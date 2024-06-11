<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class AuthController {
    public static function login(Router $router) {

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();
            
            if(empty($alertas)) {
                // Verificar quel el usuario exista
                $usuario = Usuario::where('email', $usuario->email);
                if(!$usuario || !$usuario->confirmado ) {
                    Usuario::setAlerta('error', 'El Usuario No Existe o no esta confirmado');
                } else {
                    // El Usuario existe
                    if( password_verify($_POST['password'], $usuario->password) ) {
                        
                        // Iniciar la sesión
                        session_start();    
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['apellido'] = $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['admin'] = $usuario->admin ?? null;
                        
                    } else {
                        Usuario::setAlerta('error', 'Password Incorrecto');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        // Render a la vista 
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
        ]);
    }

    public static function loginComprobar() {
        $data = $_POST;
        $usuario = Usuario::where('email', $_POST['email']);
        $response = [];
    
        if (!$usuario) {
            $response['status'] = 'error';
            $response['message'] = 'El usuario no existe.';
        } else {
            if (password_verify($_POST['password'], $usuario->password)) {
                // Iniciar la sesión
                session_start();    
                $_SESSION['id'] = $usuario->id;
                $_SESSION['nombre'] = $usuario->nombre;
                $_SESSION['apellido'] = $usuario->apellido;
                $_SESSION['email'] = $usuario->email;
                $_SESSION['telefono'] = $usuario->telefono;
                $_SESSION['admin'] = $usuario->admin ?? 0;
    
                $response['status'] = 'success';
                $response['admin'] = $_SESSION['admin'] == '1' ? true : false;
            } else {
                $response['status'] = 'error';
                $response['message'] = 'La contraseña es incorrecta.';
            }
        }
    
        // Devolver la respuesta JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }    

    public static function logout() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $_SESSION = [];
            header('Location: /');
        }
       
    }

    public static function registro(Router $router) {

        // Render a la vista
        $router->render('auth/registro', [
            'titulo' => 'Crea tu cuenta en DevWebcamp'
        ]);
    }

    public static function comprobarEmail() {
        $data = $_POST;
    
        $usuario = Usuario::where('email', $data['email']);
    
        if ($usuario) {
            $mensaje = 'El usuario ya está registrado';
        } else {
            $mensaje = '';
        }
    
        header('Content-Type: application/json');
        echo json_encode(['mensaje' => $mensaje]);
    }      

    public static function registroConfirmar() {

        $usuario = new Usuario();
        $usuario->sincronizar($_POST);
        $usuario->hashPassword();
        unset($usuario->password2);
        $usuario->crearToken();
    
        $resultado = $usuario->guardar();
    
        if ($resultado) {
            $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
            $enviado = $email->enviarConfirmacion();

            header('Content-Type: application/json');
            echo json_encode(['enviado' => $enviado]);
        }
    
    }    

    public static function olvide(Router $router) {
        $alertas = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();
    
            if (empty($alertas)) {
                // Buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);
    
                if ($usuario && $usuario->confirmado) {
    
                    // Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);
    
                    // Actualizar el usuario
                    $usuario->guardar();
    
                    // Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
    
                    $alertas['exito'] = 'Hemos enviado las instrucciones a tu email.';
                    
                } else {
                    $alertas['error'] = 'El Usuario no existe o no está confirmado.';
                }
            }
        }
    
        // Muestra la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi Password',
            'alertas' => $alertas
        ]);
    }
    

    public static function reestablecer(Router $router) {

        $token = s($_GET['token']);

        $token_valido = true;

        if(!$token) header('Location: /');

        // Identificar el usuario con este token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            $token_valido = false;
        }


        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Añadir el nuevo password
            $usuario->sincronizar($_POST);

            // Validar el password
            $alertas = $usuario->validarPassword();


            if(empty($alertas)) {
                // Hashear el nuevo password
                $usuario->hashPassword();

                // Eliminar el Token
                $usuario->token = null;

                // Guardar el usuario en la BD
                $resultado = $usuario->guardar();

                // Redireccionar
                if($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        // Muestra la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Password',
            'alertas' => $alertas,
            'token_valido' => $token_valido
        ]);
    }

    public static function mensaje(Router $router) {

        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);
    }

    public static function confirmar(Router $router) {
        
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        // Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            // No se encontró un usuario con ese token
            $alertas = false;
        } else {
            // Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = '';
            unset($usuario->password2);
            
            // Guardar en la BD
            $usuario->guardar();

            $alerta = true;
        }

     

        $router->render('auth/confirmar', [
            'titulo' => 'Gracias por Confirmar tu Cuenta',
            'alerta' => $alerta
        ]);
    }
}