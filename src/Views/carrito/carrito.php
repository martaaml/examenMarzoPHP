<section class="carrito">
    <?php if (!empty($productosCarrito)): ?>
        <?php foreach ($productosCarrito as $key => $productoCarrito): ?>

            <?php if (isset($productoCarrito['product'])) : ?>

                <?php if ($productoCarrito['product']->getBorrado() == 0): ?>
                    <article class="product-card">
                        <div class="product-card__info">
                            <p><b>Nombre:</b> <?= $productoCarrito['product']->getNombre() ?></p>
                            <p><b>Precio:</b> <?= $productoCarrito['product']->getPrecio() ?>€</p>
                        </div>
                        <div class="carrito__producto__cantidad">
                            <form action="<?= BASE_URL ?>carrito/restar" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $productoCarrito['product']->getId() ?>">
                                <button type="submit">-</button>
                            </form>

                            <p><?= $productoCarrito["cantidad"] ?></p>
                            <form action="<?= BASE_URL ?>tiendecita/carrito/sumar" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $productoCarrito['product']->getId() ?>">
                                <button type="submit">+</button>
                            </form>
                        </div>
                        <div class="carrito__producto__delete">
                            <form action="<?= BASE_URL ?>tiendecita/carrito/borrar" method="POST">
                                <input type="hidden" name="id" value="<?= $productoCarrito['product']->getId() ?>">
                                <button type="submit">Borrar</button>
                            </form>
                        </div>

                    </article>
                <?php endif; ?> 
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos en el carrito.</p>
    <?php endif; ?>
</section>


<?php if (count($_SESSION["carrito"]) > 0 && isset($_SESSION['user'])): ?>

    <section>

        <form action="<?= BASE_URL ?>pedidos" method="POST">
            PROVINCIA: <input type="text" name="provincia" required>
            LOCALIDAD <input type="text" name="localidad" required>
            DIRECCION <input type="text" name="direccion" required>
            <button type="submit">Realizar pedido</button>
        </form>
    </section>
<?php else: ?>
    <section>
        <h2>Aún no hay nada añadido:</h2>
        <a href="<?= BASE_URL ?>">Volver al inicio</a>
    </section>

    <?php if (!isset($_SESSION['user'])): ?>
        <section>
            <h2>Inicia sesión antes de realizar el pedido:</h2>
            <form action="<?= BASE_URL ?>login" method="post">
                <button name="login" value="true">Inicia sesión</button>
            </form>
        </section>

    <?php endif; ?>
<?php endif; ?>
<style>
    .product-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        margin-bottom: 15px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .product-card__info {
        flex: 2;
    }

    .product-card__info p {
        margin: 5px 0;
        font-size: 16px;
    }

    .carrito__producto__cantidad {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        justify-content: center;
    }

    .carrito__producto__cantidad p {
        font-size: 18px;
        font-weight: bold;
    }

    .carrito__producto__cantidad form {
        display: inline-block;
    }

    .carrito__producto__cantidad button,
    .carrito__producto__delete button {
        background-color: #f04e30;
        color: white;
        border: none;
        padding: 8px 12px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }

    .carrito__producto__cantidad button:hover,
    .carrito__producto__delete button:hover {
        background-color: #d13a22;
    }

    .carrito__producto__delete {
        flex: 0.5;
        text-align: right;
    }
</style>