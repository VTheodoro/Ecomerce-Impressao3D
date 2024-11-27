<?php
require './database/db.php';
require './base/header.php';

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$products_by_id = [];
foreach ($products as $product) {
    $products_by_id[$product['id']] = $product;
}

$cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];


if (empty($cart)) {
    echo "Seu carrinho está vazio.";
} else {
    $product_counts = array_count_values($cart);

    foreach ($product_counts as $product_id => $quantity) {
        if (isset($products_by_id[$product_id])) {
            $product = $products_by_id[$product_id];
            $name = $product['name'];
            $price = $product['price'];
            echo "$name: $quantity (R$" . number_format($price * $quantity, 2, ',', '.') . ")<hr>";
        } else {
            echo "Produto com ID $product_id não encontrado.<hr>";
        }
    }
}
?>
