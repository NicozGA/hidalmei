<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Usuario {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function obtenerPorEmail($email) {
        $sql = "SELECT u.*, r.nombre AS rol 
                FROM usuarios u 
                LEFT JOIN roles r ON u.id_rol = r.id_rol 
                WHERE u.email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function registrar($nombre, $email, $password, $apellido = '', $telefono = '') {
        if ($this->obtenerPorEmail($email)) {
            return false;
        }

        $id_rol = 2; // Cliente por defecto

        $sql = "INSERT INTO usuarios (id_rol, nombre, apellido, email, password, telefono, estado) 
                VALUES (:id_rol, :nombre, :apellido, :email, :password, :telefono, 'activo')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_rol', $id_rol, PDO::PARAM_INT);
        $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':telefono', $telefono, PDO::PARAM_STR);

        return $stmt->execute();
    }
}