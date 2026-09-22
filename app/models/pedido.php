<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Pedido {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function crearPedido($id_usuario, $total, $items) {
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO pedidos (id_usuario, fecha_pedido, total, estado) VALUES (:id_usuario, NOW(), :total, 'pendiente')";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindValue(':total', $total);
            $stmt->execute();

            $id_pedido = $this->db->lastInsertId();

            $sqlDetalle = "INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, precio_unitario) VALUES (:id_pedido, :id_producto, :cantidad, :precio)";
            $stmtDetalle = $this->db->prepare($sqlDetalle);

            $sqlStock = "UPDATE productos SET stock = stock - :cantidad WHERE id_producto = :id_producto";
            $stmtStock = $this->db->prepare($sqlStock);

            foreach ($items as $item) {
                $stmtDetalle->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
                $stmtDetalle->bindValue(':id_producto', $item['id'], PDO::PARAM_INT);
                $stmtDetalle->bindValue(':cantidad', $item['cantidad'], PDO::PARAM_INT);
                $stmtDetalle->bindValue(':precio', $item['precio']);
                $stmtDetalle->execute();

                $stmtStock->bindValue(':cantidad', $item['cantidad'], PDO::PARAM_INT);
                $stmtStock->bindValue(':id_producto', $item['id'], PDO::PARAM_INT);
                $stmtStock->execute();
            }

            $this->db->commit();
            return $id_pedido;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}