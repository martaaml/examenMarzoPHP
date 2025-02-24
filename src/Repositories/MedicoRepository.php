<?php

namespace Repositories;

use Lib\DataBase;
use Models\Medico;
use PDO;
use PDOException;

class MedicoRepository
{
    private PDO $sql;
    private DataBase $conection;

    public function __construct()
        {
            $this->conection = new DataBase();
            $this->sql = $this->conection->getConnection(); 
        }

    public function findAll()
    {
        try {
            $query = "SELECT * FROM medicos";
            $stmt = $this->sql->prepare($query);
            $stmt->execute();
            $medicosData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $medicos = [];
            foreach ($medicosData as $medicoData) {
                $medicos[] = Medico::fromArray($medicoData);
            }

            return $medicos;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Función para almacenar un médico
     * @param Medico $medico
     */
    public function store(Medico $medico)
    {
        try {
            $query = "INSERT INTO medicos (nombre, apellidos, telefono, especialidad) 
                      VALUES (:nombre, :apellidos, :telefono, :especialidad)";
            $stmt = $this->sql->prepare($query);
            $stmt->bindValue(":nombre", $medico->getNombre());
            $stmt->bindValue(":apellidos", $medico->getApellidos());
            $stmt->bindValue(":telefono", $medico->getTelefono());
            $stmt->bindValue(":especialidad", $medico->getEspecialidad());
            $stmt->execute();
            return null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function update(Medico $medico)
    {
        try {
            $query = "UPDATE medicos SET nombre = :nombre, apellidos = :apellidos, telefono = :telefono, 
                      especialidad = :especialidad WHERE id = :id";
            $stmt = $this->sql->prepare($query);
            $stmt->bindValue(":nombre", $medico->getNombre());
            $stmt->bindValue(":apellidos", $medico->getApellidos());
            $stmt->bindValue(":telefono", $medico->getTelefono());
            $stmt->bindValue(":especialidad", $medico->getEspecialidad());
            $stmt->bindValue(":id", $medico->getId());
            $stmt->execute();
            return null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function delete(int $id)
    {
        try {
            $query = "DELETE FROM medicos WHERE id = :id";
            $stmt = $this->sql->prepare($query);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            return null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function findById(int $id)
    {
        try {
            $query = "SELECT * FROM medicos WHERE id = :id";
            $stmt = $this->sql->prepare($query);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            $medicoData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $medicoData ? Medico::fromArray($medicoData) : null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getMedicosByEspecialidad($especialidad)
    {
        try {
            $query = "SELECT * FROM medicos WHERE especialidad = :especialidad";
            $stmt = $this->sql->prepare($query);
            $stmt->bindValue(":especialidad", $especialidad);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    public function findByCategoria($categoriaId)
{
    $stmt = $this->sql->prepare("SELECT * FROM medicos WHERE categoria_id = ?");
    $stmt->execute([$categoriaId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function reactive($id)
    {
        try {
            $stmt = $this->sql->prepare("UPDATE medicos SET reactive = 1 WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount(); 
        } catch (PDOException $e) {
            return 0; 
        }
    }
    
    public function findActive()
    {
        try {
            $stmt = $this->sql->prepare("SELECT * FROM medicos WHERE reactive = 0");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            return []; // Devuelve un array vacío en caso de error
        }
    }
    
}
