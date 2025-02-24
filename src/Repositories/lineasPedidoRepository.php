<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\LineasPedidos;
    use Models\Productos;
    use PDOException;
    use PDO;
    class lineasPedidoRepository{
        private DataBase $conection;
        private mixed $sql;
        function __construct(){
            $this->conection = new DataBase();
        } 
        /**
         * Función para buscar todas las lineas de un pedido
         * 
         * @param string id con el id del pedido
         * @return array con la lineas del pedido
         */
        public function findAll(string $id) :?array
        {
            try {
                $this->sql = $this->conection->prepareSQL("SELECT productos.*, lineas_pedidos.pedido_id,lineas_pedidos.unidades FROM productos JOIN lineas_pedidos ON productos.id = lineas_pedidos.producto_id WHERE lineas_pedidos.pedido_id = :pedido_id;");
                $this->sql->bindValue(":pedido_id", $id);
                $this->sql->execute();
                $result = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
            } catch (PDOException $e) {
                $result = $e->getMessage();
            }
            $this->sql = null;
            return $result;
        }
        /**
         * Función para crear un nuevo pedido con una transacion
         * 
         * @param string id con el id del pedido
         * @return string si hay error
         */
        public function nuevoPedido(string $id) :?string {
            try{
                $this->conection->beginTransaction();
                foreach ($_SESSION['carrito'] as $value) {
                    $this->sql = $this->conection->prepareSQL("INSERT INTO lineas_pedidos(pedido_id,producto_id,unidades) VALUES (:pedido_id,:producto_id,:unidades);");
                    $this->sql->bindValue(":pedido_id",$id);
                    $this->sql->bindValue(":producto_id",unserialize($value['producto'])[0]->getId());
                    $this->sql->bindValue(":unidades",$value['unidades']);
                    $this->sql->execute();
                }
                $this->conection->commit();
                $result = null;
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
    }