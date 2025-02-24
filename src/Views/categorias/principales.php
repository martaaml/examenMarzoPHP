<div id="categorias">
  <h2>Categorías</h2>
  <div v-for="categoria in categorias" :key="categoria.id" class="card" @click="viewCategoria(categoria.id)">
    <h3>{{ categoria.nombre }}</h3>
  </div>
</div>

<style>
  .card {
    background-color: #7FFFD4;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 6px;
    margin: 8px 0;
    width: 25%;
    height: auto;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    cursor: pointer; /* Hace que parezca clickeable */
    transition: transform 0.2s ease-in-out;
  }

  .card:hover {
    transform: scale(1.05);
  }

  .card h3 {
    margin: 0 0 8px;
  }
</style>

<script>
  const { createApp } = Vue;

  createApp({
    data() {
      return {
        categorias: <?php echo json_encode($categorias); ?>
      }
    },
    methods: {
      viewCategoria(id) {
        window.location.href = "<?= BASE_URL ?>productos/categoria/" + id;
      }
    }
  }).mount('#categorias')
</script>