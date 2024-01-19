<?php

require_once("config/database.php");

class Model{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $this->conexion->exec("SET NAMES UTF8");
    }

    public function obtenerUsuarios()
    {
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Crea un nuevo usuario en la base de datos.
     * @param string $nombre
     * @param string $apellido
     * @param string $dni
     * @return bool
     */
    public function crearUsuario(string $nombre, string $apellido, string $dni)
    {
        try {
            $query = "INSERT INTO usuarios (nombre, apellido, dni) VALUES (:nombre, :apellido, :dni)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindValue(':apellido', $apellido, PDO::PARAM_STR);
            $stmt->bindValue(':dni', $dni, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception('Error al crear el usuario: ' . $e->getMessage());
        }
    }
    /**
     * Actualiza los datos de un usuario en la base de datos.
     * @param int $id
     * @param string $nombre
     * @param string $apellido
     * @param string $dni
     * @return bool
     */
    public function modificarUsuario(int $id, string $nombre, string $apellido, string $dni)
    {
        try {
            $query = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, dni = :dni WHERE id = :id";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindValue(':apellido', $apellido, PDO::PARAM_STR);
            $stmt->bindValue(':dni', $dni, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception('Error al modificar el usuario: ' . $e->getMessage());
        }
    }
    /**
     * Elimina un usuario de la base de datos.
     * @param int $id
     * @return bool
     */
    public function eliminarUsuario(int $id)
    {
        try {
            $query = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception('Error al eliminar el usuario: ' . $e->getMessage());
        }
    }
}
