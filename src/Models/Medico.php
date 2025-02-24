<?php

namespace Models;
/*Clase para el modelo de médicos*/
class Medico
{
    private int $id;
    private string $nombre;
    private string $apellidos;
    private string $telefono;
    private string $especialidad;

    /*Constructor*/

    public function __construct(
        int $id,
        string $nombre,
        string $apellidos,
        string $telefono,
        string $especialidad
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->especialidad = $especialidad;
    }

    // Métodos GETTERS y SETTERS

    /*ID*/
    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /*Nombre*/
    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    /*Apellidos*/
    public function getApellidos(): string
    {
        return $this->apellidos;
    }
    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;
        return $this;
    }

    /*Telefono*/
    public function getTelefono(): string
    {
        return $this->telefono;
    }
    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;
        return $this;
    }

    /*Especialidad*/
    public function getEspecialidad(): string
    {
        return $this->especialidad;
    }
    public function setEspecialidad(string $especialidad): self
    {
        $this->especialidad = $especialidad;
        return $this;
    }

    // Método fromArray
    public static function fromArray(array $data): Medico
    {
        return new Medico(
            id: isset($data['id']) ? (int) $data['id'] : 0,
            nombre: $data['nombre'] ?? '',
            apellidos: $data['apellidos'] ?? '',
            telefono: $data['telefono'] ?? '',
            especialidad: $data['especialidad'] ?? ''
        );
    }

    // Método toArray
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'telefono' => $this->telefono,
            'especialidad' => $this->especialidad
        ];
    }
}
