<?php

namespace Services;

use Repositories\MedicoRepository;
use Models\Medico;
use PDOException;
use Lib\Database;
use PDO;


class MedicoService
{
    private MedicoRepository $medicoRepository;

    public function __construct()
    {
        $db = new Database(); 
        $pdo = $db->getConnection(); 
    
        $this->medicoRepository = new MedicoRepository($pdo); 
    }
    


    public function getMedicosDisponibles()
    {
        $db = new Database();
        $pdo = $db->getConnection(); // Obtener la conexión correctamente
    
        $sql = "SELECT id, nombre, apellidos, especialidad FROM medicos";
        $stmt = $pdo->query($sql); // Usar $pdo en lugar de $db
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getMedicosByCategoria($categoriaId)
{
    return $this->medicoRepository->findByCategoria($categoriaId);
}

    public function getHorasDisponibles($medicoId, $fecha)
    {
        $db = new Database();
        $db->getConnection();
        

        // Definir el rango de horas disponibles
        $horas = ['09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00'];

        // Obtener horas ocupadas por el médico en esa fecha
        $stmt = $db->prepare("SELECT hora FROM citas WHERE medico_id = ? AND fecha = ?");
        $stmt->execute([$medicoId, $fecha]);

        $horasOcupadas = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Asegurar que $horasOcupadas es un array
        if (!$horasOcupadas) {
            $horasOcupadas = [];
        }

        // Filtrar horas disponibles
        return array_values(array_diff($horas, $horasOcupadas));
    }


    public function findActive()
    {
        try {
            $result = $this->medicoRepository->findActive(); // Asumiendo que existe este método en el repositorio
            return $result ?: []; // Devuelve un array vacío si no hay resultados
        } catch (PDOException $e) {
            return []; // En caso de error, devuelve un array vacío en lugar del mensaje de error
        }
    }


    /**
     * Obtener todos los médicos
     * @return array|null
     */
    public function getAllMedicos()
    {
        return $this->medicoRepository->findAll();
    }

    /**
     * Obtener un médico por su ID
     * @param int $id
     * @return Medico|null
     */
    public function getMedicoById(int $id)
    {
        return $this->medicoRepository->findById($id);
    }

    /**
     * Guardar un nuevo médico
     * @param Medico $medico
     * @return string|null
     */
    public function createMedico(Medico $medico)
    {
        try {
            return $this->medicoRepository->store($medico);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Actualizar un médico existente
     * @param Medico $medico
     * @return string|null
     */
    public function updateMedico(Medico $medico)
    {
        try {
            return $this->medicoRepository->update($medico);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Eliminar un médico
     * @param int $id
     * @return string|null
     */
    public function deleteMedico($id)
    {
        try {
            $medico = $this->medicoRepository->findById($id); // Obtiene el objeto Medico
            if (!$medico) {
                return "El médico no existe.";
            }

            return $this->medicoRepository->delete($id);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function reactive($id)
    {
        try {
            return $this->medicoRepository->reactive($id);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
