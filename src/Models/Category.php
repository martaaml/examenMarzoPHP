<?php
namespace Models;
class Category
{
    private string $id;
    private string $nombre;
    private bool $borrado;
    public function __construct(
        string $id = null,
        string $nombre,
        bool $borrado = false
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->borrado = $borrado;
    }
    //GEETER DEL ID
    public function getId(): ?string
    {
        return $this->id;
    }
    //SETTER DEL ID
    public function setId(?string $id): void
    {
        $this->id = $id;
    }
    //GETTER DEL NOMBRE
    public function getNombre(): string
    {
        return $this->nombre;
    }
    //SETTER DEL NOMBRE
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }
    //GETTER DEL BORRADO
    public function getBorrado(): bool
    {
        return $this->borrado;
    }
    //SETTER DEL BORRADO
    public function setBorrado(bool $borrado): void
    {
        $this->borrado = $borrado;
    }

    //Metodo fromarray
    public static function fromArray(array $data): Category{
        return new Category(
            id: $data['id']??'',
            nombre: $data['nombre']??'',
            borrado: $data['borrado']??false
        );
    }

    //Metodo toArray
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'borrado' => $this->borrado
        ];
    }

    

}