<?php require 'views/header.php'; 

//images + the reservation form for a travel

?>
<a href="index.php" class="back-link">&larr; Back to the catalog</a>

<h1><?= htmlspecialchars($travel['title'] ?? '') ?></h1>

<?php if (!empty($error)): ?>
    <div class="alert error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="gallery">
    <?php if (!empty($images)): ?>
        <?php foreach ($images as $img): ?>
            <img src="images/<?= htmlspecialchars(trim($img)) ?>" alt="<?= htmlspecialchars($travel['title'] ?? '') ?>"
                style="max-width: 200px; height: auto; border-radius: 6px;">
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="details">
    <p><strong>Destination:</strong> <?= htmlspecialchars($travel['destination'] ?? '') ?></p>
    <p><strong>Category:</strong> <?= htmlspecialchars($travel['category'] ?? '') ?></p>
    <p><strong>Transport:</strong> <?= htmlspecialchars($travel['transport'] ?? '') ?></p>
    <p><strong>Price:</strong> <?= htmlspecialchars($travel['daily_price'] ?? '0') ?> € / day</p>
    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($travel['description'] ?? '')) ?></p>
</div>

<div class="booking-box">
    <h3>Reserve this trip</h3>
    <form action="index.php?action=add_to_cart" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($travel['id'] ?? '') ?>">

        <label for="date_start">Departure date:</label>
        <input type="date" id="date_start" name="date_start" required>

        <label for="date_end">Return date:</label>
        <input type="date" id="date_end" name="date_end" required>

        <button type="submit" class="btn">Add to the cart</button>
    </form>
</div>

<?php require 'views/footer.php'; ?>