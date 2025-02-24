<?php
// Cuántos registros deben mostrarse por página
$records_per_page = 5;

// Instanciamos el objeto de paginación
$pagination = new Zebra_Pagination();

// La cantidad total de registros es el número de médicos en la base de datos
$pagination->records(count($medicos));

// Registros por página
$pagination->records_per_page($records_per_page);

// Aquí la magia: necesitamos mostrar solo los médicos de la página actual
$medicos = array_slice(
    $medicos,
    (($pagination->get_page() - 1) * $records_per_page),
    $records_per_page
);
?>

<div id="medicos" class="medicos-container">
    <div class="medico-card" v-for="medico in medicos" :key="medico.id">
        <h2>{{ medico.nombre }} {{ medico.apellidos }}</h2>
        <p><strong>Teléfono:</strong> {{ medico.telefono }}</p>
        <p><strong>Especialidad:</strong> {{ medico.especialidad }}</p>
        <div class="d-flex gap-2 actions">
            <form action="examenMarzoMarta/carrito/restar" method="post">
                <input type="hidden" name="id" v-model="product.id">
                <button class="btn btn-primary"><i class="mdi mdi-minus"></i></button>
            </form>
       
            <form action="examenMarzoMarta/carrito/sumar" method="post">
                <input type="hidden" name="id" v-model="product.id">
                <button class="btn btn-primary"><i class="mdi mdi-plus"></i></button>
            </form>
        </div>

        </div>
    </div>
</div>

<?php
    // Renderiza la paginación
    $pagination->render();
?>

<script>
  const { createApp } = Vue;

  createApp({
    data() {
      return {
        medicos:  <?php echo json_encode($medicos); ?>,  // Los médicos
        sesion: <?php echo json_encode($_SESSION); ?>     // La sesión, si es necesario
      }
    }
  }).mount('#medicos')
</script>

<style>
  /* General Container */
.medicos-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    padding: 20px;
}

/* Medico Card */
.medico-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    flex: 1 1 calc(33.333% - 20px); /* 3 cards per row */
    max-width: calc(33.333% - 20px);
    text-align: center;
    padding: 15px;
}

/* Card Hover Effect */
.medico-card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}

/* Medico Details */
.medico-card h2 {
    font-size: 1.5em;
    margin-bottom: 10px;
    color: #333;
}

.medico-card p {
    margin: 5px 0;
    color: #666;
}

/* Actions (Buttons) */
.actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
}

.actions .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.actions .btn:hover {
    background-color: #0056b3;
}

/* Media queries for responsive design */
@media (max-width: 768px) {
    .medicos-container {
        flex-direction: column;
        gap: 10px;
        padding: 10px;
        margin-top: 20px;
    }
    .medico-card {
        flex: 1 1 calc(50% - 10px); /* 2 cards per row */
        max-width: calc(50% - 10px);
    }
}
</style>
