<?php
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $query = $pdo->prepare('SELECT * FROM usuarios WHERE usuario = :usuario AND password = :password');
    $query->execute(['usuario' => $usuario, 'password' => $password]);
    $user = $query->fetch();

    if ($user) {
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['id_usuario'] = $user['id_usuario'];
        header('Location: listado.php');
        exit;
    } else {
        $error = 'Credenciales incorrectas.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <h1>Iniciar Sesión</h1>
    <form method="POST">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
</body>

</html>