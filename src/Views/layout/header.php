<html>
<head>
    <title>MARO STORE</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>


<header class="container" style="background-color: #f2f2f2; width: 100%; height: 100%;">
    <h1 style="text-align: center; margin: 0; padding: 20px 0   ;">MARO SHOP</h1>      
    <nav style="display: flex; justify-content: center; gap: 10px; background-color: #1e7054; padding: 10px 0;">

        <?php if (isset($_SESSION['user'])) : ?>
            <p style="text-align: center; font-size: 18px; color:#f2f2f2">¿Como te encuentras, <?= htmlspecialchars($_SESSION['user']['nombre']) ?>?</p>

            <a href="<?= BASE_URL ?>logout" style="text-decoration: none; color: white; padding: 10px 20px; background-color: #005f40; border-radius: 5px; text-align: center;">Cerrar sesión</a>
            <a href="<?= BASE_URL ?>citas" style="text-decoration: none; color: white; padding: 10px 20px; background-color: #005f40; border-radius: 5px; text-align: center;">Tus citas</a>
        <?php else : ?>
            <a href="<?= BASE_URL ?>login" style="text-decoration: none; color: white; padding: 10px 20px; background-color: #005f40; border-radius: 5px; text-align: center;">Iniciar sesión</a>
            <a href="<?= BASE_URL ?>register" style="text-decoration: none; color: white; padding: 10px 20px; background-color: #005f40; border-radius: 5px; text-align: center;">Registrarse</a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>categorias" style="text-decoration: none; color: white; padding: 10px 20px; background-color: #005f40; border-radius: 5px; text-align: center;">Categorías</a>
        <a href="<?= BASE_URL ?>" style="text-decoration: none; color: white; padding: 10px 20px; background-color: #005f40; border-radius: 5px; text-align: center;">Medicos</a>
        <a href="<?= BASE_URL ?>carrito" style="text-decoration: none; color: white; padding: 10px 20px; background-color: #005f40; border-radius: 5px; text-align: center;">Confirmar citas</a>

        <?php if (isset($_SESSION['admin'])) : ?>
            <a href="<?= BASE_URL ?>admin" style="text-decoration: none; color: white; padding: 10px 20px; background-color: #005f40; border-radius: 5px; text-align: center;">Admin</a>
        <?php endif; ?>

    </nav>
</header>
<?php if (isset($_SESSION['success'])) : ?>
    <div class="alert alert-success" role="alert">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php 
    $_SESSION['success']=NULL;

    header("Refresh: 5")
    ?>
<?php endif; ?>
    <main>  