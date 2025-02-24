<?php

namespace Models;


class LineasPedidos{
    public function __construct(
        private string|null $id = null,
        private string $pedido_id,
        private string $producto_id,
        private string $unidades
    ){}
    // Getter y Setter para $id
    public function getId(): ?string {
        return $this->id;
    }

    public function setId(?string $id): void {
        $this->id = $id;
    }

    // Getter y Setter para $pedido_id
    public function getPedido_id(): string {
        return $this->pedido_id;
    }

    public function setPedido_id(string $pedido_id): void {
        $this->pedido_id = $pedido_id;
    }
    // Getter y Setter para $producto_id
    public function getProducto_id(): string {
        return $this->producto_id;
    }

    public function setProducto_id(string $producto_id): void {
        $this->producto_id = $producto_id;
    }
    // Getter y Setter para $unidades
    public function getUnidades(): string {
        return $this->unidades;
    }

    public function setUnidades(string $unidades): void {
        $this->unidades = $unidades;
    }

    public static function fromArray(array $data): LineasPedidos
    {
        return new LineasPedidos(
            $data['id'] ?? null,
            $data['pedido_id'] ?? "",
            $data['producto_id'] ?? "",
            $data['unidades'] ?? "",
        );
    }
}