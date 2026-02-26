<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class UsuariosController
{
    // Muestra y procesa el login
    public function login()
    {

        // Si ya está logueado, muestra el listado
        if (isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=abonos&action=listado");
            exit;
        }

        $username = "";
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = trim($_POST["username"] ?? "");
            $password = trim($_POST["password"] ?? "");

            if ($username === "" || $password === "") {
                $error = "Debes rellenar todos los campos.";
            } else {
                $modelo = new UsuarioModel();

                if ($modelo->login($username, $password)) {
                    $_SESSION["usuario"] = $username;
                    header("Location: index.php?controller=abonos&action=listado");
                    exit;
                } else {
                    $error = "Usuario o contraseña incorrectos.";
                }
            }
        }

        // Cargamos la vista
        require_once __DIR__ . "/../Views/Usuarios/LoginView.php";
    }

    // Cierra la sesión
    public function logout()
    {
        session_destroy();
        header("Location: Index.php");
        exit;
    }
}
