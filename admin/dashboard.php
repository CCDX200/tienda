<?php
session_start();
include 'includes/config.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['delete'])) {
    $conn->query("DELETE FROM products WHERE id=" . $_GET['delete']);
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $qty = $_POST['quantity'];
    $conn->query("UPDATE products SET name='$name', description='$desc', price='$price', quantity='$qty' WHERE id=$id");
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $qty = $_POST['quantity'];
    $conn->query("INSERT INTO products (name, description, price, quantity) VALUES ('$name', '$desc', '$price', '$qty')");
    header("Location: dashboard.php");
    exit();
}

$products = $conn->query("SELECT * FROM products");
$purchases = $conn->query("SELECT p.id, pr.name, p.quantity, p.created_at FROM purchases p JOIN products pr ON p.product_id = pr.id ORDER BY p.created_at DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin</title>
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Panel de Administración</h2>
        <a href="logout.php">Cerrar sesión</a>
        <h3>Agregar nuevo producto</h3>
        <form method="POST">
            <input type="hidden" name="add" value="1">
            <input type="text" name="name" placeholder="Nombre del producto" required><br>
            <textarea name="description" placeholder="Descripción"></textarea><br>
            <input type="number" name="price" step="0.01" placeholder="Precio"><br>
            <input type="number" name="quantity" step="1" placeholder="Cantidad"><br>
            <button type="submit">Agregar Producto</button>
        </form>
        <hr>
        <h3>Productos</h3>
        <ul>
        <?php while ($row = $products->fetch_assoc()) { ?>
            <li>
                <form method="POST" style="margin-bottom: 10px;">
                    <input type="hidden" name="update" value="1">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="text" name="name" value="<?= $row['name'] ?>" required>
                    <input type="text" name="description" value="<?= $row['description'] ?>">
                    <input type="number" name="price" step="0.01" value="<?= $row['price'] ?>">
                    <input type="number" name="quantity" value="<?= $row['quantity'] ?>">
                    <button type="submit">Guardar</button>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar producto?')">Eliminar</a>
                </form>
            </li>
        <?php } ?>
        </ul>
        <hr>
        <h3>Compras realizadas</h3>
        <table>
            <thead>
                <tr><th>ID</th><th>Producto</th><th>Cantidad</th><th>Fecha</th></tr>
            </thead>
            <tbody>
            <?php while ($row = $purchases->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>