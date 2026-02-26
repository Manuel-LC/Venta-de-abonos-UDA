<?php

namespace App\Models;

use PDO;
use App\ConexionBD;
use Exception;
use PDOException;

class TipoAbonoModel
{
    private PDO $conexion;

    public function __construct()
    {
        $this->conexion = ConexionBD::getInstance()->getConexion();
    }

    // Método para obtener todos los datos de la tabla "tipo_abonos"
    public function obtenerTodos(): array
    {
        try{
        $stmt = $this->conexion->query("SELECT * FROM tipo_abonos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("ERROR: No pudieron obtener los tipos de abono.");
        }
    }

    // Método que consulta el precio según un id
    public function obtenerPrecio(string $id): float
    {
        try{
        $stmt = $this->conexion->prepare("SELECT precio FROM tipo_abonos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new Exception("ERROR: No se pudo obtener el precio.");
        }
    }
}
