<?php require 'views/header.php'; 

//display catalog + filter by category

?>

<h1>Available destinations</h1>

<form method="GET" action="index.php" class="filter-box">
    <label for="category">Filter by category:</label>
    <select name="category" id="category" onchange="this.form.submit()">
        <option value="all">All categories</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>" <?= (isset($_GET['category']) && $_GET['category'] === $cat) ? 'selected' : '' ?>>
                <?= ucfirst(htmlspecialchars($cat)) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<div class="travel-grid">
    <?php if (empty($travels)): ?>
        <p>There are no trips for the selected category.</p>
    <?php else: ?>
        <?php foreach ($travels as $t): ?>
            <div class="travel-card">
                <h3><?= htmlspecialchars($t['title']) ?></h3>
                <p><strong>Destination:</strong> <?= htmlspecialchars($t['destination']) ?></p>
                <p><strong>Category:</strong> <span class="badge"><?= htmlspecialchars($t['category']) ?></span></p>
                <p><strong>Transport:</strong> <?= htmlspecialchars($t['transport']) ?></p>
                <p class="price"><?= htmlspecialchars($t['daily_price']) ?> € / day</p>
                <a href="index.php?action=detail&id=<?= $t['id'] ?>" class="btn">See details</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require 'views/footer.php'; ?>