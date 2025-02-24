<?php
namespace Controllers;

use Lib\Pages;
use Services\MedicoService;
use PDOException;

class CarritoController
{
    private Pages $pages;
    private MedicoService $medicoService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->medicoService = new MedicoService();
    }

    public function index()
    {
        $citasPendientes = $_SESSION['carrito'] ?? [];
        $this->pages->render('carrito/citas', ['citas' => $citasPendientes]);
    }

    public function agregarCita()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $medicoId = $_POST['medico_id'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];

            // Validar disponibilidad
            $horasDisponibles = $this->medicoService->getHorasDisponibles($medicoId, $fecha);
            if (!in_array($hora, $horasDisponibles)) {
                $_SESSION['error'] = 'Esa hora ya está ocupada. Escoge otra.';
                header('Location: ' . BASE_URL . 'carrito');
                return;
            }

            // Agregar la cita al carrito
            $_SESSION['carrito'][] = [
                'medico_id' => $medicoId,
                'fecha' => $fecha,
                'hora' => $hora
            ];

            $_SESSION['success'] = 'Cita añadida al carrito.';
            header('Location: ' . BASE_URL . 'carrito');
        }
    }

    public function confirmarCitas()
    {
        if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
            $_SESSION['error'] = 'No tienes citas pendientes.';
            header('Location: ' . BASE_URL . 'carrito');
            return;
        }

        $db = Database::getConnection();
        $pacienteId = $_SESSION['user']['id'];

        try {
            $db->beginTransaction();

            foreach ($_SESSION['carrito'] as $cita) {
                $stmt = $db->prepare("INSERT INTO citas (medico_id, paciente_id, fecha, hora) VALUES (?, ?, ?, ?)");
                $stmt->execute([$cita['medico_id'], $pacienteId, $cita['fecha'], $cita['hora']]);
            }

            $db->commit();
            $_SESSION['carrito'] = [];  // Limpiar carrito
            $_SESSION['success'] = 'Citas confirmadas con éxito.';
        } catch (PDOException $e) {
            $db->rollBack();
            $_SESSION['error'] = 'Error al confirmar las citas.';
        }

        header('Location: ' . BASE_URL . 'carrito');
    }

    public function cancelarCita()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['index'])) {
            $index = $_POST['index'];
            unset($_SESSION['carrito'][$index]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar array

            $_SESSION['success'] = 'Cita eliminada del carrito.';
            header('Location: ' . BASE_URL . 'carrito');
        }
    }
}
