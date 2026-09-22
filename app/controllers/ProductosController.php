<?php
namespace App\Controllers;

use Core\Controller;

class ProductosController extends Controller {
    private $productoModel;

    public function __construct() {
        $this->productoModel = $this->model('Producto');
    }

    public function index() {
        $productos = $this->productoModel->obtenerTodos();
        $this->view('productos/index', ['productos' => $productos]);
    }
}