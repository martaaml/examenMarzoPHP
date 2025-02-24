<?php
namespace Models;
use Lib\Validar;

class Pedido
{
    private  $id;
    private string $usuario_id;
    private string $provincia;
    private string $localidad;
    private string $direccion;
    private float $coste;
    private string $estado;
    private string $fecha;
    private string $hora;
    private bool $borrado;
    public function __construct(
        $id = null,
        string $usuario_id,
        string $provincia,
        string $localidad,
        string $direccion,
        float $coste,
        string $estado,
        string $fecha,
        string $hora
    ) {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->provincia = $provincia;
        $this->localidad = $localidad;
        $this->direccion = $direccion;
        $this->coste = $coste;
        $this->estado = $estado;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->borrado = false;
    }
    

    //GETTER DEL ID DEL PEDIDO
    public function getId(): ?string
    {
        return $this->id;
    }

    //SETTER DEL ID DEL PEDIDO
    public function setId(?string $id): void
    {
        $this->id = $id;

    }

    //GETTER DEL ID DEL USUARIO DEL PEDIDO
    public function getUsuarioId(): string
    {
        return $this->usuario_id;
    }

    //SETTER DEL ID DEL USUARIO DEL PEDIDO
    public function setUsuarioId(string $usuario_id): void
    {
        $this->usuario_id = $usuario_id;

    }

    //GETTER DEL PROVINCIA DEL PEDIDO
    public function getProvincia(): string
    {
        return $this->provincia;
    }

    //SETTER DEL PROVINCIA DEL PEDIDO
    public function setProvincia(string $provincia): void
    {
        $this->provincia = $provincia;

    }

    //GETTER DEL LOCALIDAD DEL PEDIDO
    public function getLocalidad(): string
    {
        return $this->localidad;
    }

    //SETTER DEL LOCALIDAD DEL PEDIDO
    public function setLocalidad(string $localidad): void
    {
        $this->localidad = $localidad;

    }

    //GETTER DEL DIRECCION DEL PEDIDO
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    //SETTER DEL DIRECCION DEL PEDIDO
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;

    }

    //GETTER DEL COSTE DEL PEDIDO
    public function getCoste(): float
    {
        return $this->coste;
    }

    //SETTER DEL COSTE DEL PEDIDO
    public function setCoste(float $coste): void
    {
        $this->coste = $coste;

    }

    //GETTER DEL ESTADO DEL PEDIDO
    public function getEstado(): string
    {
        return $this->estado;
    }

    //SETTER DEL ESTADO DEL PEDIDO
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;

    }

    //GETTER DEL FECHA DEL PEDIDO
    public function getFecha(): string
    {
        return $this->fecha;
    }

    //SETTER DEL FECHA DEL PEDIDO
    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;


    }

    //GETTER DEL HORA DEL PEDIDO
    public function getHora(): string
    {
        return $this->hora;
    }

    //SETTER DEL HORA DEL PEDIDO
    public function setHora(string $hora): void
    {
        $this->hora = $hora;


    }

    //GETTER DEL BORRADO DEL PEDIDO
    public function getBorrado(): bool
    {
        return $this->borrado;
    }

    //SETTER DEL BORRADO DEL PEDIDO
    public function setBorrado(bool $borrado): void
    {
        $this->borrado = $borrado;


    }
    //Metodo fromarray
    public static function fromArray(array $data): Pedido{
        return new Pedido(
            id: $data['id']??null,
            usuario_id: $data['usuario_id']??'',
            provincia: $data['provincia']??'',
            localidad: $data['localidad']??'',
            direccion: $data['direccion']??'',
            coste: $data['coste']??'',
            estado: $data['estado']??'',
            fecha: $data['fecha']??'',
            hora: $data['hora']??''
        );
    }

    //Metodo toArray
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'usuario_id' => $this->usuario_id,
            'provincia' => $this->provincia,
            'localidad' => $this->localidad,
            'direccion' => $this->direccion,
            'coste' => $this->coste,
            'estado' => $this->estado,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'borrado' => $this->borrado
        ];
    }

    public function validarPedido(){
        $array =["pendiente","enviado"];
        if (!empty($name) && !Validar::validar_array($name,$array)){
            $errores['estado'] = "Estado no posible";
        }
    
        return $errores;
    }
}