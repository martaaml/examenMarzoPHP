<?php
    namespace Services;
    use Repositories\lineasPedidoRepository;
    class lineasPedidoService{
        // Creando variable con
        private lineasPedidoRepository $repository;
        function __construct() {
            $this->repository = new lineasPedidoRepository();
        }
        /**
         * Función para buscar una linea de pedido
         * @param string $id con el id del pedido
         * @return array con todas las lineas de ese pedido
         */
        public function findAll(string $id) :?array {
            return $this->repository->findAll($id);
        }
        /**
         * Función para buscar una linea de pedido
         * @param string $datos con el id del pedido
         */
        public function nuevoPedido(string $datos):void{
            $this->repository->nuevoPedido($datos);
        }
    }