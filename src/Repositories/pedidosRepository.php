<?php
namespace Repositories;
use Lib\DataBase;
use Models\Pedido;
use PDOException;
use PDO;
class pedidosRepository
{
    private DataBase $conection;
    private mixed $sql; 
    public function __construct()
    {
        $this->conection = new DataBase();
    }

    /*Funcion para obtener todos los pedidos*/
    public function findAll()
    {
        $pedidos = [];
        try {
            $this->conection->querySQL("SELECT * FROM pedidos");
            $pedidosData = $this->conection->allRegister();
            foreach ($pedidosData as $pedidoData) {
                $pedidos[] = Pedido::fromArray($pedidoData);
            }
        } catch (PDOException $e) {
            $pedidos = null;
        }
        return $pedidos;
    }
    /*Funcion para obtener los pedidos del usuario logueado*/
    public function mios()
    {
        $pedidos = [];
        try {
            $this->sql=$this->conection->prepareSQL("SELECT * FROM pedidos where usuario_id = :id");
            $this->sql->bindValue(":id", $_SESSION['user']['id']);
            $this->sql->execute();
            $pedidosData = $this->sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($pedidosData as $pedidoData) {
                $pedidos[] = Pedido::fromArray($pedidoData);
            }
        } catch (PDOException $e) {
            $pedidos = null;
        }
        return $pedidos;
    }


    /*Funcion para almacenar un pedido*/
    public function store($pedido)
    {
        try {
            $this->sql = $this->conection->prepareSQL(
                "INSERT INTO pedidos(usuario_id,provincia,localidad,direccion,coste,estado,fecha,hora) VALUES (:usuario_id,:provincia,:localidad,:direccion,:coste,:estado,:fecha,:hora)"
            );
            $this->sql->bindValue(":usuario_id", $pedido->getUsuarioId());;
            $this->sql->bindValue(":provincia", $pedido->getProvincia());
            $this->sql->bindValue(":localidad", $pedido->getLocalidad());
            $this->sql->bindValue(":direccion", $pedido->getDireccion());
            $this->sql->bindValue(":coste", $pedido->getCoste());
            $this->sql->bindValue(":estado", $pedido->getEstado());
            $this->sql->bindValue(":fecha", $pedido->getFecha());
            $this->sql->bindValue(":hora", $pedido->getHora());
            $this->sql->execute();
            //Coger el ultimo resultado insertado
            $result = $this->conection->lastInsertId();
        } catch (PDOException $e) {

            $result = $e->getMessage();
        }
        $this->sql->closeCursor();
        return $result;
    }

    /*Funcion para actualizar un pedido*/
    public function update($pedido)
    {
        try {
            $this->sql = $this->conection->prepareSQL(                
                "UPDATE pedidos SET estado = :estado WHERE id = :id"
            );
            $this->sql->execute();
            $result = null;
        } catch (PDOException $e) {

            $result = $e->getMessage();
        }
        $this->sql->closeCursor();
        return $result;
    }

    /*Funcion para borrar un pedido*/
    public function delete($pedido)
    {
        try {
            $this->sql = $this->conection->prepareSQL(
                "UPDATE pedidos SET borrado = 1 WHERE id = :id"
            );
            $this->sql->bindValue(":id", $pedido->getId());
            $this->sql->execute();
            $result = null;

        } catch (PDOException $e) {
            
            $result = $e->getMessage();
        }
        $this->sql->closeCursor();
        return $result;

    }

    /*Funcion para obtener los pedidos activos*/
    public function findActive()
    {
        $pedidos = [];
        try {
            $this->conection->querySQL("SELECT * FROM pedidos");
            $pedidosData = $this->conection->allRegister();
            foreach ($pedidosData as $pedidoData) {
                $pedidos[] = Pedido::fromArray($pedidoData);
            }
        } catch (PDOException $e) {
            $pedidos = null;
        }
        return $pedidos;
    }   

    /*Funcion para obtener un pedido*/
    public function ver(int $id)
    {
        $pedido = null;
        try {
            $this->conection->querySQL("SELECT * FROM pedidos WHERE id = :id");
            $pedidoData = $this->conection->allRegister();
            $pedido = Pedido::fromArray($pedidoData[0]);
        } catch (PDOException $e) {
            $pedido = null;
        }
        return $pedido;
    }

    public function actualizarEstado($id, $estado)
    {
        try {
            $sql = "UPDATE pedidos SET estado = :estado WHERE id = :id";
            $stmt = $this->conection->prepare($sql);
            $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    

}