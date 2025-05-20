<?php
include '../admin/includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = (int) $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];

    $stmt = $conn->prepare("SELECT quantity FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product && $product['quantity'] >= $quantity) {
        $new_quantity = $product['quantity'] - $quantity;
        $update = $conn->prepare("UPDATE products SET quantity = ? WHERE id = ?");
        $update->bind_param("ii", $new_quantity, $product_id);
        $update->execute();
        $log = $conn->prepare("INSERT INTO purchases (product_id, quantity) VALUES (?, ?)");
        $log->bind_param("ii", $product_id, $quantity);
        $log->execute();
        $message = "¡Compra realizada con éxito!";
    } else {
        $message = "No hay suficiente inventario.";
    }
} else {
    $message = "Acceso inválido.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de Compra</title>
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2><?= $message ?></h2>
        <a href="index.php">Volver a la tienda</a>
    </div>
</body>
</html>