<?php
namespace Core;

class Controller {
    public function model($model) {
        $fullModelName = "App\\Models\\" . $model;
        return new $fullModelName();
    }

    public function view($view, $data = []) {
        extract($data);
        if (file_exists(__DIR__ . '/../app/views/' . $view . '.php')) {
            require_once __DIR__ . '/../app/views/' . $view . '.php';
        } else {
            die("La vista " . htmlspecialchars($view) . " no existe.");
        }
    }
}