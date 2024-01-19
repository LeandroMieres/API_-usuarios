<?php
require_once("Controller/Controller.php");

header("Content-Type: application/json");

$request_method = $_SERVER['REQUEST_METHOD'];

$usuarioController = new Controller();

try {
    switch ($request_method) {
        case 'GET':
            $usuarioController->index();
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            if ($usuarioController->validarDatos($data, ['nombre', 'apellido', 'dni'])) {
                $usuarioController->create($data['nombre'], $data['apellido'], $data['dni']);
            } else {
                throw new Exception("Error: Datos de entrada incompletos o inválidos");
            }
            break;
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            if ($usuarioController->validarDatos($data, ['id', 'nombre', 'apellido', 'dni'])) {
                $usuarioController->update($data['id'], $data['nombre'], $data['apellido'], $data['dni']);
            } else {
                throw new Exception("Error: Datos de entrada incompletos o inválidos");
            }
            break;
        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            if ($usuarioController->validarDatos($data, ['id'])) {
                $usuarioController->delete($data['id']);
            } else {
                throw new Exception("Error: Datos de entrada incompletos o inválidos");
            }
            break;
        default:
            http_response_code(405); // Método no permitido
            echo json_encode(["mensaje" => "Método no permitido"]);
            break;
    }
} catch (Exception $e) {
    http_response_code(400); // Bad Request
    echo json_encode(["mensaje" => $e->getMessage()]);
}
