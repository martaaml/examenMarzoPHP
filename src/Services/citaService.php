<?php

namespace Services;

use Lib\DataBase;
use PDO;

class CitaService
{
    private DataBase $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    /**
     * Verifica si un médico tiene disponible un horario
     */
    public function esHorarioDisponible(int $medico_id, string $fecha, string $hora): bool
    {
        $sql = "SELECT COUNT(*) FROM citas WHERE medico_id = ? AND fecha = ? AND hora = ?";
        $stmt = $this->db->prepareSQL($sql);
        $stmt->execute([$medico_id, $fecha, $hora]);

        return $stmt->fetchColumn() == 0;
    }

    /**
     * Registra una nueva cita en la base de datos
     */
    public function registrarCita(int $usuario_id, int $medico_id, string $fecha, string $hora): bool
    {
        $sql = "INSERT INTO citas (usuario_id, medico_id, fecha, hora, estado) VALUES (?, ?, ?, ?, 'pendiente')";
        $stmt = $this->db->prepareSQL($sql);
        return $stmt->execute([$usuario_id, $medico_id, $fecha, $hora]);
    }
}
