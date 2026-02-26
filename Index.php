<?php
// Index.php
require_once "ConexionBD.php";

session_start();

// Autoload
spl_autoload_register(function ($clase) {

    // Solo cargamos clases del namespace App
    if (strpos($clase, 'App\\') !== 0) {
        return;
    }

    // Eliminamos el namespace base
    $ruta = str_replace("App\\", "", $clase);

    // Convertimos namespace en rutas
    $ruta = str_replace("\\", "/", $ruta);

    // Ruta final del archivo
    $archivo = __DIR__ . "/" . $ruta . ".php";

    if (file_exists($archivo)) {
        require_once $archivo;
    }
});

//  Router ?controller=usuarios&action=login
$controller = preg_replace('/[^a-zA-Z]/', '', $_GET["controller"] ?? "abonos");
$action     = preg_replace('/[^a-zA-Z]/', '', $_GET["action"] ?? "compra");


// Convertimos a nombre de clase
$controllerClass = "App\\Controllers\\" . ucfirst($controller) . "Controller";

if (!class_exists($controllerClass)) {
    die("Controlador no encontrado");
}

// Instanciamos controlador
$controlador = new $controllerClass();

// Comprobamos acción
if (!method_exists($controlador, $action)) {
    die("Acción no válida");
}

// Ejecutamos acción
$controlador->$action();
