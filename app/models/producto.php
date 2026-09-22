<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Producto {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function obtenerTodos() {
        $sql = "SELECT p.*, c.nombre AS categoria_nombre, pr.nombre_comercial AS proveedor_nombre 
                FROM productos p 
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria 
                INNER JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor 
                ORDER BY p.id_producto DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM productos WHERE id_producto = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
}