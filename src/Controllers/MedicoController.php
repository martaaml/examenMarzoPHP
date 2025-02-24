<?php

namespace Controllers;

use Lib\Pages;
use Services\MedicoService;
use Models\Medico;
use PDOException;

/**
 * Clase de controlador para manejar médicos
 * @package Controllers
 */
class MedicoController
{
    private Pages $pages;
    private MedicoService $medicosService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->medicosService = new MedicoService();
    }

    /**
     * Función para mostrar los médicos
     * @return void
     */
    public function index()
    {
        $medicoService = new MedicoService();
        $medicos = $medicoService->findActive();
    
        if ($medicos) {
            $medicos = array_map(fn($medico) => $medico->toArray(), $medicos);
        } else {
            $medicos = []; // Asegura que siempre haya un array para evitar errores
        }
    
        $this->pages->render('Medico/destacados', ['medicos' => $medicos]);
    }
    
    
    /**
     * Función para almacenar un médico
     * @return void
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['nombre']) && !empty($_POST['apellidos']) && isset($_POST['telefono']) && is_numeric($_POST['telefono']) && !empty($_POST['especialidad']) && !empty($_POST['fecha_ingreso']) && !empty($_POST['imagen'])) {
                
                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                $telefono = $_POST['telefono'];
                $especialidad = $_POST['especialidad'];
                $fecha_ingreso = $_POST['fecha_ingreso'];
                $imagen = $_POST['imagen'];

                $medicoData = [
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'telefono' => $telefono,
                    'especialidad' => $especialidad,
                    'fecha_ingreso' => $fecha_ingreso,
                    'imagen' => $imagen
                ];

                if (!empty($_POST['id'])) {
                    $medicoData['id'] = $_POST['id'];
                    $medico = Medico::fromArray($medicoData);
                    try {
                        $this->medicosService->updateMedico($medico);
                        $_SESSION['success'] = 'Médico editado';
                        header('Location: ' . BASE_URL);
                        exit;
                    } catch (PDOException $e) {
                        $_SESSION['error'] = 'Ha surgido un error';
                    }
                } else {
                    $medico = Medico::fromArray($medicoData);
                    try {
                        $this->medicosService->createMedico($medico);
                        $_SESSION['success'] = 'Médico creado';
                        header('Location: ' . BASE_URL);
                        exit;
                    } catch (PDOException $e) {
                        $_SESSION['error'] = 'Ha surgido un error';
                    }
                }
            } else {
                $_SESSION['error'] = 'Faltan datos';
            }
        } else {
            $_SESSION['error'] = 'Método inválido';
        }
        $this->pages->render('Medico/principales');
    }

    /**
     * Función para borrar un médico
     * @param int $id
     * @return void
     */
    public function delete()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $medicoService = new MedicoService();
            $medico = $medicoService->getMedicoById($id);

            if ($medico) {
                $result = $medicoService->deleteMedico($id);
                $_SESSION['success'] = 'Médico eliminado';
                header('Location: ' . BASE_URL);
                return;
            }
        }
    }

    /**
     * Función para reactivar un médico
     * @return void
     */
    public function reactive()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id']; // Obtener el ID desde el formulario o solicitud POST
            $medicoService = new MedicoService();
            $medico = $medicoService->getMedicoById($id);

            if ($medico) {
                $result = $medicoService->reactive($id);
                $_SESSION['success'] = 'Médico reactivado';
                header('Location: ' . BASE_URL);
                return;
            }
        }
    }
    public function mostrarMedicosPorCategoria($categoriaId)
    {
        $medicos = $this->medicosService->getMedicosByCategoria($categoriaId);
        include __DIR__ . '/../Views/medicosPorCategoria.php';
    }
    /**
     * Función para actualizar un médico
     * @return void
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $medico = $this->medicosService->getMedicoById($id);

            if (!$medico) {
                $_SESSION['error'] = 'El médico no existe';
                header('Location: ' . BASE_URL . 'medicos');
                return;
            }

            // Renderiza la vista de edición con el médico seleccionado
            $this->pages->render('medicos/editar', ['medico' => $medico]);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id'], $_POST['nombre'], $_POST['apellidos'], $_POST['telefono'], $_POST['especialidad'])) {
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                $telefono = $_POST['telefono'];
                $especialidad = $_POST['especialidad'];

                $medicoData = [
                    'id' => $id,
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'telefono' => $telefono,
                    'especialidad' => $especialidad
                ];

                $medico = Medico::fromArray($medicoData);

                try {
                    $this->medicosService->updateMedico($medico);
                    $_SESSION['success'] = 'Médico actualizado correctamente';
                    header('Location: ' . BASE_URL . 'medicos');
                    return;
                } catch (PDOException $e) {
                    $_SESSION['error'] = 'Error al actualizar el médico';
                }
            }
        }
    }
}
