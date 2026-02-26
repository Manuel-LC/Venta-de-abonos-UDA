<?php

namespace App\Models;

use PDO;
use App\ConexionBD;
use Exception;
use PDOException;

class AbonoModel
{
    private PDO $conexion;

    public function __construct()
    {
        $this->conexion = ConexionBD::getInstance()->getConexion();
    }

    public function insertarAbono(array $datos): void
    {
        try {
            $sql = "
            INSERT INTO abonos 
            (id, fecha, abonado, edad, telefono, cuenta_bancaria, tipo, asiento, precio)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                $datos['id'],
                $datos['fecha'],
                $datos['abonado'],
                $datos['edad'],
                $datos['telefono'],
                $datos['cuenta'],
                $datos['tipo'],
                $datos['asiento'],
                $datos['precio']
            ]);
        } catch (Exception $e) {
            throw new Exception("ERROR: No se puede insertar el abono en la base de datos.");
        }
    }

    public function obtenerPorId(string $id): array
    {
        try {
            $sql = "
            SELECT a.*, t.descripcion AS tipo_desc
            FROM abonos a
            JOIN tipo_abonos t ON a.tipo = t.id
            WHERE a.id = ?
        ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("ERROR: No se pudieron obtener los datos para el ticket.");
        }
    }

    public function obtenerTodos(): array
    {
        try {
            $sql = "
            SELECT a.*, t.descripcion AS tipo_descripcion
            FROM abonos a
            JOIN tipo_abonos t ON a.tipo = t.id
            ORDER BY a.asiento DESC
        ";
        } catch (PDOException $e) {
            throw new Exception("ERROR: No se pudieron obtener los datos para el listado.");
        }

        return $this->conexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function asientoExiste(string $asiento): bool
    {
        try{
        $stmt = $this->conexion->prepare("SELECT COUNT(*) FROM abonos WHERE asiento = ?");
        $stmt->execute([$asiento]);
        return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new Exception("ERROR: No se pudo verificar si existe ese asiento.");
        }
    }

    public function getIconoTipo(string $tipo): string
    {
        return match ($tipo) {
            'Tribuna'     => 'oro.png',
            'Preferencia' => 'plata.png',
            'Fondo'       => 'bronce.png',
        };
    }

    public function getTipoEspecial(int $edad): string
    {
        if ($edad < 12) return "Niño/a";
        if ($edad > 65) return "Jubilado/a";
        return "—";
    }

    // Validaciones
    public function validar(array $datosFormulario): array
    {
        $errores = [];

        if ($datosFormulario["nombre_apellidos"] === "") {
            $errores["nombre_apellidos"] = "Nombre obligatorio";
        }

        if (!preg_match("/^[0-9]{8}[A-Z]$/", $datosFormulario["dni"])) {
            $errores["dni_aficionado"] = "DNI no válido";
        }

        if ($datosFormulario["fecha_nacimiento"] === "") {
            $errores["fecha_nacimiento"] = "Fecha obligatoria";
        }

        if (!preg_match("/^[0-9]{9}$/", $datosFormulario["telefono"])) {
            $errores["telefono_aficionado"] = "Teléfono no válido";
        }

        if (!preg_match("/^ES[0-9]{22}$/", $datosFormulario["cuenta"])) {
            $errores["cuenta_bancaria"] = "Cuenta bancaria no válida";
        }

        if ($datosFormulario["tipo_abono"] === "") {
            $errores["tipo_abono"] = "Debe seleccionar un tipo de abono";
        }

        if (!$datosFormulario["acepto"]) {
            $errores["acepto_terminos"] = "Debe aceptar los términos";
        }

        return $errores;
    }

    public function usuarioLogueado(): bool
    {
        if (isset($_SESSION["usuario"]) && $_SESSION["usuario"] === "uda") {
            return true;
        } else {
            return false;
        }
    }
}
