<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="logo">🌍 Travel Website</div>
        <nav class="nav">
            <a href="index.php">Trips Catalog</a>
            <a href="index.php?action=cart">Cart (<?= count($_SESSION['cart'] ?? []) ?>)</a>
        </nav>
    </header>
    <main class="container">