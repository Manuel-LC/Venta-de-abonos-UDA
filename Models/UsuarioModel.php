<?php
// Models/UsuarioModel.php

namespace App\Models;

use PDO;
use App\ConexionBD;

class UsuarioModel
{
    // Conexión PDO
    private PDO $conexion;

    // Constructor que obtiene la conexión a la base de datos mediante singleton
    public function __construct()
    {
        // Obtenemos la instancia única de la conexión
        $this->conexion = ConexionBD::getInstance()->getConexion();
    }

    /**
     * Método para autenticar un usuario
     *
     * @param string $username
     * @param string $password
     * @return bool true si el login es correcto, false si no
     */
    public function login(string $username, string $password): bool
    {
        $sql = "SELECT password FROM usuarios WHERE username = :username LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();

        // Obtenemos el hash almacenado
        $hash = $stmt->fetchColumn();

        // Si existe el usuario y la contraseña coincide
        if ($hash && password_verify($password, $hash)) {
            return true;
        }

        return false;
    }
}
