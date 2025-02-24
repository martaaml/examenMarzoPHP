<?php

namespace Services;

use Repositories\pedidosRepository;

class pedidosService
{
    protected pedidosRepository $pedidosRepository;
    function __construct()
    {
        $this->pedidosRepository = new pedidosRepository();
    }

    /**
     * Función para obtener todos los pedidos
     * 
     */
    public function findAll(): array
    {
        return $this->pedidosRepository->findAll();
    }

    /**
     * Función para obtener los pedidos del usuario logueado
     */
    public function mios(): array
    {
        return $this->pedidosRepository->mios();
    }
    /**
     * Función para almacenar un pedido
     * @param Product $product
     * @return string
     */
    public function store($pedido)
    {
        return $this->pedidosRepository->store($pedido);
    }

    /**
     * Función para actualizar un pedido
     * @param Product $product
     * @return string
     */
    public function update($pedido)
    {
        return $this->pedidosRepository->update($pedido);
    }

    /**
     * Función para borrar un pedido
     * @param Product $product
     * @return string
     */
    public function delete($pedido)
    {
        return $this->pedidosRepository->delete($pedido);
    }
    /**
     * Funcion para obtener todos los pedidos activos
     */
    public function findActive()
    {
        return $this->pedidosRepository->findActive();
    }
    /**
     * Funcion para obtener un pedido por su id
     */
    public function ver(int $id)
    {
        return $this->pedidosRepository->ver($id);
    }
    public function actualizarEstado($id, $estado)

    {
        return $this->pedidosRepository->actualizarEstado($id, $estado);
    }
}