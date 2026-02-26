<?php

namespace App\Controllers;

use App\Models\AbonoModel;
use App\Models\TipoAbonoModel;
use Exception;

class AbonosController
{
    // Compra de abonos
    public function compra()
    {
        $modeloTipos = new TipoAbonoModel();
        $modeloAbono = new AbonoModel();

        try {
            $tipos_abono = $modeloTipos->obtenerTodos();
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            require __DIR__ . "/../Views/ErrorView.php";
            return;
        }

        // Lee cookies (si existen)
        $nombre_apellidos = $_COOKIE["nombre_apellidos"] ?? "";
        $dni              = $_COOKIE["dni"] ?? "";
        $fecha_nacimiento = $_COOKIE["fecha_nacimiento"] ?? "";
        $telefono         = $_COOKIE["telefono"] ?? "";
        $cuenta           = $_COOKIE["cuenta"] ?? "";

        // Procesa formulario
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $nombre_apellidos = trim($_POST["nombre_apellidos"] ?? "");
            $dni              = trim($_POST["dni_aficionado"] ?? "");
            $fecha_nacimiento = $_POST["fecha_nacimiento"] ?? "";
            $telefono         = trim($_POST["telefono_aficionado"] ?? "");
            $cuenta           = trim($_POST["cuenta_bancaria"] ?? "");
            $tipo_abono       = $_POST["tipo_abono"] ?? "";
            $acepto           = isset($_POST["acepto_terminos"]);

            $datosFormulario = [
                "nombre_apellidos" => $nombre_apellidos,
                "dni" => $dni,
                "fecha_nacimiento" => $fecha_nacimiento,
                "telefono" => $telefono,
                "cuenta" => $cuenta,
                "tipo_abono" => $tipo_abono,
                "acepto" => $acepto
            ];

            // Validaciones usando un método
            $errores = $modeloAbono->validar($datosFormulario);

            // Si no hay errores...
            if (empty($errores)) {

                // Guardamos cookies
                setcookie("nombre_apellidos", $nombre_apellidos, time() + 60 * 60 * 24 * 30);
                setcookie("dni", $dni, time() + 60 * 60 * 24 * 30);
                setcookie("fecha_nacimiento", $fecha_nacimiento, time() + 60 * 60 * 24 * 30);
                setcookie("telefono", $telefono, time() + 60 * 60 * 24 * 30);
                setcookie("cuenta", $cuenta, time() + 60 * 60 * 24 * 30);

                // Calculamos edad
                $edad = date_diff(
                    date_create($fecha_nacimiento),
                    date_create("today")
                )->y;

                // Precio
                try {
                    $precio = $modeloTipos->obtenerPrecio($tipo_abono);
                } catch (Exception $e) {
                    $mensaje = $e->getMessage();
                    require __DIR__ . "/../Views/ErrorView.php";
                    return;
                }

                // Generamos id
                $id = sprintf(
                    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    random_int(0, 0xffff),
                    random_int(0, 0xffff),
                    random_int(0, 0xffff),
                    random_int(0, 0x0fff) | 0x4000,
                    random_int(0, 0x3fff) | 0x8000,
                    random_int(0, 0xffff),
                    random_int(0, 0xffff),
                    random_int(0, 0xffff)
                );

                // Generamos el código de asiento
                $intentos = 0;
                $asiento_valido = false;

                do {
                    $sector = rand(1, 5);
                    $bloque = rand(1, 5);
                    $fila = rand(0, 29);
                    $asientos_max = 140 + (2 * $fila);
                    $asiento = rand(0, $asientos_max - 1);

                    $codigo_asiento = sprintf(
                        "%dB%d/F%02d-A%03d",
                        $sector,
                        $bloque,
                        $fila,
                        $asiento
                    );

                    try {
                        if (!$modeloAbono->asientoExiste($codigo_asiento)) {
                            $asiento_valido = true;
                            break;
                        }
                    } catch (Exception $e) {
                        $mensaje = $e->getMessage();
                        require __DIR__ . "/../Views/ErrorView.php";
                        return;
                    }

                    $intentos++;
                } while ($intentos < 5);

                // Datos para insertar
                $datos = [
                    "id" => $id,
                    "fecha" => date("Y-m-d H:i:s"),
                    "abonado" => "$nombre_apellidos - $dni",
                    "edad" => $edad,
                    "telefono" => $telefono,
                    "cuenta" => $cuenta,
                    "tipo" => $tipo_abono,
                    "asiento" => $codigo_asiento,
                    "precio" => $precio
                ];

                try {
                    $modeloAbono->insertarAbono($datos);
                } catch (Exception $e) {
                    $mensaje = $e->getMessage();
                    require __DIR__ . "/../Views/ErrorView.php";
                    return;
                }

                header("Location: index.php?controller=abonos&action=ticket&id=$id");
                return;
            }
        }

        require_once __DIR__ . "/../Views/Abonos/CompraView.php";
    }

    // Listado de abonos
    public function listado()
    {
        $modelo = new AbonoModel();

        $usuarioLogueado = $modelo->usuarioLogueado();

        /* Si el usuario no está logueado o no es el correcto, mostramos mensaje indicando que no se puede 
        acceder a esa información */
        if ($usuarioLogueado === false) {
            require __DIR__ . "/../Views/ErrorView.php";
            return;
        }

        // Se intentan obtener los datos para el listado
        try {
            $abonos = $modelo->obtenerTodos();
        } catch (Exception $e) {
            $mensajeError = $e->getMessage();
            require __DIR__ . "/../Views/ErrorView.php";
        }

        foreach ($abonos as &$abono) {
            $abono['icono'] = $modelo->getIconoTipo($abono['tipo_descripcion']);
            $abono['especial'] = $modelo->getTipoEspecial($abono['edad']);
        }

        require_once __DIR__ . "/../Views/Abonos/ListadoView.php";
    }

    // Ticket
    public function ticket()
    {
        $id = $_GET["id"] ?? null;

        $modelo = new AbonoModel();

        // Se intentan obtener los datos para el ticket
        try {
            $ticket = $modelo->obtenerPorId($id);
        } catch (\Exception $e) {
            $mensajeError = $e->getMessage();
            require __DIR__ . "/../Views/ErrorView.php";
            return;
        }

        require_once __DIR__ . "/../Views/Abonos/TicketView.php";
    }
}
