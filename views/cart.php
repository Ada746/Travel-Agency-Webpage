<?php require 'views/header.php';

//displays cart and simulates payment

?>

<h1>Your cart</h1>

<?php if (!empty($success)): ?>
    <div class="alert success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if (empty($cartItems)): ?>
    <p>Your cart is empty. <a href="index.php">Choose a destination from the catalog.</a></p>
<?php else: ?>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Destination</th>
                <th>Period of time</th>
                <th>Days</th>
                <th>Price per day</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($item['title']) ?></strong> (<?= htmlspecialchars($item['destination']) ?>)
                    </td>
                    <td><?= htmlspecialchars($item['date_start']) ?> &rarr; <?= htmlspecialchars($item['date_end']) ?></td>
                    <td><?= $item['days'] ?></td>
                    <td><?= $item['daily_price'] ?> €</td>
                    <td><?= $item['total_price'] ?> €</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" style="text-align: right;">Total cost:</th>
                <th><?= $total ?> €</th>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 20px; text-align: right;">
        <a href="index.php?action=pay" class="btn btn-pay"
            onclick="return confirm('Do you confirm the payment of the cart?');">Pay now (Simulation)</a>
    </div>
<?php endif; ?>

<?php require 'views/footer.php'; ?>
