<head>
    <title>Registro</title>
</head>
<body>
<h1>Registro</h1>
    <form action="<?=BASE_URL?>register"method="post">
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" name="data[nombre]" id="nombre" required>
        </div>
        <div>
            <label for="apellidos">Apellido</label>
            <input type="text" name="data[apellidos]" id="apellido" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="data[email]" id="email" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="data[password]" id="password" required>
        </div>
        <div>
            <label for="telefono">Telefono</label>
            <input type="text" name="data[telefono]" id="telefono" required>
            <p>Debe contener 9 dígitos numéricos</p>
        </div>
        <div>
            <label for="DNI">DNI</label>
            <input type="text" name="data[DNI]" id="DNI" required>
            <p>Debe contener 11 dígitos numéricos</p>
        </div>
        <input type="submit" value="registro">
    </form>
</body>
</html> 