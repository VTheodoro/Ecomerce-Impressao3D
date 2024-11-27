<?php
session_start();
require './database/db.php';
require 'add_to_cart.php';
require './base/header.php';

if (!isset($_COOKIE['cart'])) {
    $_COOKIE['cart'] = [];
}

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (array_key_exists("add_to_cart", $_POST)) {
    add_to_cart(intval($_POST['product_id']));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printh 3D - E-commerce de Produtos Impressos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('images/hero-banner.jpg') no-repeat center center;
            background-size: cover;
            height: 400px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.7);
        }
        .card-img-top {
            height: 200px;
            width: 100%;
            object-fit: contain;
            background-color: #f8f9fa;
        }
        .product-card {
            transition: transform 0.2s ease-in-out;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
        .footer {
            background-color: #333;
            color: white;
            padding: 30px 0;
        }
        .footer a {
            color: #ddd;
        }
        .footer a:hover {
            color: #fff;
        }
    </style>
</head>
<body>

<!-- Header -->
<header class="hero-section">
    <div class="text-center">
        <h1>Bem-vindo à Printh 3D</h1>
        <p>Produtos exclusivos e personalizados impressos em 3D para você!</p>
    </div>
</header>

<div class="container mt-4">
    <h2 class="text-center mb-4">Produtos de Impressão 3D</h2>
    <div class="row">
        <?php 
        $totalProducts = count($products); 
        for ($i = 0; $i < $totalProducts; $i++):
            $product = $products[$i];
        ?>
            <div class="col-md-4 mb-4">
                <div class="card product-card shadow-sm">
                    <img src="images/<?php echo $product['image']; ?>" class="card-img-top mx-auto d-block" alt="<?php echo $product['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text">R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></p>
                        <form method="post" action="#<?php echo $i ?>">
                            <button type="submit" class="btn btn-primary" name="add_to_cart">Adicionar ao Carrinho</button>
                            <input type="hidden" value="<?php echo $i ?>" name="product_id">
                        </form>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>

<!-- Footer -->
<footer class="footer text-center">
    <div class="container">
        <p>&copy; 2024 Printh 3D | <a href="#">Política de Privacidade</a> | <a href="#">Termos de Serviço</a></p>
    </div>
</footer>

<?php require './base/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>