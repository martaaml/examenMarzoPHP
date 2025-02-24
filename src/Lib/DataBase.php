<?php
namespace Lib;

use PDO;
use PDOException;

class DataBase extends PDO
{
    private $conexion;
    private mixed $result; // mixed para todos los valores

    public function __construct()
    {
        $server = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        $data_base = $_ENV['DB_DATABASE'];

        try {
            $opciones = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                PDO::MYSQL_ATTR_FOUND_ROWS => true
            );
            // Inicializar el constructor de PDO (no necesitas la propiedad $pdo)
            parent::__construct("mysql:host={$server};dbname={$data_base}", $user, $pass, $opciones);
            // Configurar el modo de manejo de errores para la conexión
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Ha surgido un error y no se puede conectar con la base de datos: " . $e->getMessage();
            exit;
        }
    }

    /**
     * Función para pasar una sentencia SQL
     */
    public function querySQL(string $querySQL): void
    {
        $this->result = $this->query($querySQL);
    }

    /**
     * Función para obtener el último registro
     */
    public function register(): array
    {
        return ($fila = $this->result->fetch(PDO::FETCH_ASSOC)) ? $fila : false;
    }

    /**
     * Función para obtener todos los registros
     */
    public function allRegister(): array
    {
        return $this->result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Sentencia SQL preparada
     */
    public function prepareSQL(string $querySQL)
    {
        return $this->prepare($querySQL);
    }

    public function getConnection(): PDO
    {
        return $this; // Devuelves la instancia de PDO directamente
    }
}
