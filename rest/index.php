<?php

/**
 * Step 1: Require the Slim Framework using Composer's autoloader
 *
 * If you are not using Composer, you need to load Slim Framework with your own
 * PSR-4 autoloader.
 */
//taddibrisa.com/ObtenerCopiadoras?q=octocat

require 'vendor/autoload.php';
require 'Conexion.php';
require 'Controladores/ControllerCliente.php';
require 'Controladores/ControllerChofer.php';
require 'Entidades/Cliente.php';
require 'Entidades/LoginCliente.php';
require 'Entidades/LoginChofer.php';
require 'Entidades/FormularioCliente.php';
require 'Entidades/FormularioChofer.php';
require 'Entidades/Chofer.php';
require 'Entidades/Agencia.php';
require 'Entidades/Vehiculo.php';
require 'Entidades/Ejecutivo.php';
require 'Entidades/Dia.php';
require 'Entidades/Hora.php';
require 'utileria.php';

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new Slim\Container($configuration);

$app = new Slim\App($c);

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */
$app->get('/', function ($request, $response, $args) {
    $response->write("Welcome to Slim");
    return $response;
});


$app->get('/hello[/{name}]', function ($request, $response, $args) {
    $response->write("Hello, " . $args['name']);
    return $response;
})->setArgument('name', 'World!');


$app->get('/ObtenerChoferes', '\ControllerChofer:ObtenerChoferes');

$app->post('/registrarChofer', '\ControllerChofer:registrarChofer');

$app->post('/actualizarUbicacion', '\ControllerChofer:actualizarUbicacion');

$app->post('/actualizarEnServicio', '\ControllerChofer:actualizarEnServicio');

$app->post('/actualizarConexion', '\ControllerChofer:actualizarConexion');

$app->post('/aceptarServicio', '\ControllerChofer:aceptarServicio');

$app->post('/terminarViaje', '\ControllerChofer:terminarViaje');

$app->post('/registrarToken', '\ControllerChofer:registrarToken');

$app->post('/registrarCliente', '\ControllerCliente:registrarCliente');

$app->post('/registrarCita', '\ControllerCliente:registrarCita');

$app->post('/loginCliente', '\ControllerCliente:loginCliente');

$app->post('/loginChofer', '\ControllerChofer:loginChofer');

$app->get('/ObtenerAgencias', '\ControllerCliente:ObtenerAgencias');

$app->post('/cargarVehiculos', '\ControllerCliente:cargarVehiculos');

$app->post('/cargarEjecutivos', '\ControllerCliente:cargarEjecutivos');

$app->post('/cargarDias', '\ControllerCliente:cargarDias');

$app->post('/cargarHoras', '\ControllerCliente:cargarHoras');

$app->post('/editarVehiculo', '\ControllerCliente:editarVehiculo');

$app->post('/eliminarVehiculo', '\ControllerCliente:eliminarVehiculo');

$app->post('/agregarVehiculo', '\ControllerCliente:agregarVehiculo');



/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
