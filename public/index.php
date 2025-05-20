<?php
include '../admin/includes/config.php';
$products = $conn->query("SELECT * FROM products WHERE quantity > 0");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda en Línea</title>
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Bienvenido a nuestra Tienda</h1>
        <div class="product-grid">
        <?php while ($row = $products->fetch_assoc()) { ?>
            <div class="product-card">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p><?= htmlspecialchars($row['description']) ?></p>
                <p><strong>$<?= number_format($row['price'], 2) ?></strong></p>
                <p>Disponible: <?= $row['quantity'] ?></p>
                <form method="POST" action="purchase.php">
                    <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                    <input type="number" name="quantity" value="1" min="1" max="<?= $row['quantity'] ?>">
                    <button type="submit">Comprar</button>
                </form>
            </div>
        <?php } ?>
        </div>
        <hr>
        <a href="../admin/login.php">Administración</a>
    </div>
</body>
</html>