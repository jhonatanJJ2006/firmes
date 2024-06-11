<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\DashboardController;

$router = new Router();


// AUTH --------------------------------------------------------------------------------------------

// Login
$router->get('/auth/login', [AuthController::class, 'login']);
$router->post('/auth/login', [AuthController::class, 'login']);
$router->post('/auth/login/comprobar', [AuthController::class, 'loginComprobar']);
$router->post('/auth/logout', [AuthController::class, 'logout']);

// Crear Cuenta
$router->get('/auth/registro', [AuthController::class, 'registro']);
$router->post('/auth/registro/email-comprobar', [AuthController::class, 'comprobarEmail']);
$router->post('/auth/registro/confirmar', [AuthController::class, 'registroConfirmar']);

// Formulario de olvide mi password
$router->get('/auth/olvide', [AuthController::class, 'olvide']);
$router->post('/auth/olvide', [AuthController::class, 'olvide']);

// Colocar el nuevo password
$router->get('/auth/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/auth/reestablecer', [AuthController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/auth/mensaje', [AuthController::class, 'mensaje']);
$router->get('/auth/mensaje-no', [AuthController::class, 'mensajeNo']);
$router->get('/auth/confirmar-cuenta', [AuthController::class, 'confirmar']);

// Desloguearse
$router->post('/logout', [AuthController::class, 'logout']);


// DASHBOARD ----------------------------------------------------------------------------

$router->get('/', [DashboardController::class, 'index']);
$router->get('/pdf', [DashboardController::class, 'pdf']);

$router->comprobarRutas();