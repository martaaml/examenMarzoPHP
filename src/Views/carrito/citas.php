<h2>Confirmacion de Citas</h2>

<?php if (!empty($citasCarrito)) : ?>
    <ul>
        <?php foreach ($citasCarrito as $index => $cita) : ?>
            <li>
                Médico ID: <?= $cita['medico_id']; ?> | 
                Fecha: <?= $cita['fecha']; ?> | 
                Hora: <?= $cita['hora']; ?>
                <form method="POST" action="<?= BASE_URL ?>carrito/eliminar">
                    <input type="hidden" name="index" value="<?= $index; ?>">
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <form method="POST" action="<?= BASE_URL ?>carrito/confirmar">
        <button type="submit">Confirmar Citas</button>
    </form>
<?php else : ?>
    <p>No hay citas en el carrito.</p>
<?php endif; ?>
