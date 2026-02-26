<?php

namespace App;

use PDO;
use PDOException;

class ConexionBD
{
    private static ?ConexionBD $instancia = null;
    private PDO $conexion;

    // Constructor privado
    private function __construct()
    {
        // Creamos objeto de configuración
        $config = new Config();

        try {
            $this->conexion = new PDO(
                "mysql:host={$config->host};dbname={$config->dbname};charset=utf8mb4",
                $config->user,
                $config->pass
            );

            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    // Método que devuelve la instancia única
    public static function getInstance(): ConexionBD
    {
        if (self::$instancia === null) {
            self::$instancia = new ConexionBD();
        }
        return self::$instancia;
    }

    // Método que devuelve la conexión PDO
    public function getConexion(): PDO
    {
        return $this->conexion;
    }
}
