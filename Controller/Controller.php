<?php
require_once("Model/Modelo.php");

class Controller {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Model();
    }

    // Obtener todos los usuarios
    public function index() {
        try {
            $usuarios = $this->usuarioModel->obtenerUsuarios();
            echo json_encode(["data" => $usuarios]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => "Error interno del servidor"]);
        }
    }

    // Crear un nuevo usuario
    public function create($nombre, $apellido, $dni) {
        try {
            $this->usuarioModel->crearUsuario($nombre, $apellido, $dni);
            echo json_encode(["mensaje" => "Usuario creado exitosamente"]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => "Error interno del servidor"]);
        }
    }

    // Actualizar un usuario
    public function update($id, $nombre, $apellido, $dni) {
        try {
            $this->usuarioModel->modificarUsuario($nombre, $apellido, $dni, $id);
            echo json_encode(["mensaje" => "Usuario actualizado exitosamente"]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => "Error interno del servidor"]);
        }
    }

    // Eliminar un usuario
    public function delete($id) {
        try {
            $this->usuarioModel->eliminarUsuario($id);
            echo json_encode(["mensaje" => "Usuario eliminado exitosamente"]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => "Error interno del servidor"]);
        }
    }

    public function validarDatos($data, $keys) {
        foreach ($keys as $key) {
            if (!isset($data[$key]) || empty($data[$key])) {
                return false;
            }
        }
        return true;
    }
}
?>
