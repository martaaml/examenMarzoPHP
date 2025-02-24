<form action="<?=BASE_URL?>login" method="post">
<div>
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required>
</div>
<div>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>
</div>
<a href="forgotPassword.php">¿Olvidaste tu contraseña?</a>

<input type="submit" value="Iniciar Sesion">
</form>