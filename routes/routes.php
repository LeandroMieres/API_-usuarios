<?php

require_once("Controller/Controller.php");

class Routes {

    private $usuarioController;

    public function __construct() {
        $this->usuarioController = new Controller();
    }

    public function manejarRutas() {
        $request_method = $_SERVER['REQUEST_METHOD'];

        switch ($request_method) {
            case 'GET':
                $this->usuarioController->index();
                break;
            case 'POST':
                $this->usuarioController->create($_POST['nombre'], $_POST['apellido'], $_POST['dni']);
                break;
            case 'PUT':
                parse_str(file_get_contents('php://input'), $_PUT);
                $this->usuarioController->update($_PUT['id'], $_PUT['nombre'], $_PUT['apellido'], $_PUT['dni']);
                break;
            case 'DELETE':
                parse_str(file_get_contents('php://input'), $_DELETE);
                $this->usuarioController->delete($_DELETE['id']);
                break;
            default:
                http_response_code(405); // Método no permitido
                echo json_encode(["mensaje" => "Método no permitido"]);
                break;
        }
    }
}

$routes = new Routes();
$routes->manejarRutas();

?>