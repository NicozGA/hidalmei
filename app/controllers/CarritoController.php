<?php
namespace App\Controllers;

use Core\Controller;

class CarritoController extends Controller {
    private $productoModel;

    public function __construct() {
        $this->productoModel = $this->model('Producto');
    }

    public function index() {
        $carrito = $_SESSION['carrito'] ?? [];
        $this->view('carrito/index', ['carrito' => $carrito]);
    }

    public function agregar($id = null) {
        if ($id) {
            $producto = $this->productoModel->obtenerPorId($id);
            if ($producto) {
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = [];
                }

                if (isset($_SESSION['carrito'][$id])) {
                    $_SESSION['carrito'][$id]['cantidad']++;
                } else {
                    $_SESSION['carrito'][$id] = [
                        'id' => $producto['id_producto'],
                        'nombre' => $producto['nombre'],
                        'precio' => $producto['precio'],
                        'cantidad' => 1
                    ];
                }
            }
        }
        header('Location: /carrito');
        exit;
    }

    public function eliminar($id = null) {
        if ($id && isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }
        header('Location: /carrito');
        exit;
    }

    public function vaciar() {
        unset($_SESSION['carrito']);
        header('Location: /carrito');
        exit;
    }

    public function checkout() {
        $carrito = $_SESSION['carrito'] ?? [];
        if (empty($carrito)) {
            header('Location: /productos');
            exit;
        }

        $id_usuario = $_SESSION['usuario_id'] ?? 1;
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        $pedidoModel = $this->model('Pedido');
        $id_pedido = $pedidoModel->crearPedido($id_usuario, $total, $carrito);

        if ($id_pedido) {
            unset($_SESSION['carrito']);
            $this->view('carrito/confirmacion', ['id_pedido' => $id_pedido]);
        } else {
            echo "Error al procesar la compra.";
        }
    }
}