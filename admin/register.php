<?php
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    if ($stmt->execute()) {
        echo "Administrador registrado con éxito.";
    } else {
        echo "Error al registrar.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Admin</title>
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Registrar Admin</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Usuario" required><br>
            <input type="password" name="password" placeholder="Contraseña" required><br>
            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>