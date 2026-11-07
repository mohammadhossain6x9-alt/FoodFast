<?php require 'config.php'; $pageTitle='Food Fast | Home'; include 'partials/header.php';
$restaurants=$pdo->query("SELECT r.*,u.name AS owner FROM restaurants r JOIN users u ON u.id=r.user_id WHERE r.approved=1 ORDER BY r.id DESC LIMIT 6")->fetchAll();
?>
<section class="hero"><div><h1>Your favourite food,<br><span style="color:#f47721">fast at your door.</span></h1><p>Discover local restaurants and order delicious meals from your area.</p><a class="btn" href="restaurants.php">Explore restaurants</a></div><div class="hero-art">🍔 🍕 🍟</div></section>
<div class="section-head"><h2>Popular restaurants</h2><a href="restaurants.php">View all →</a></div>
<div class="grid"><?php foreach($restaurants as $r): ?><article class="card"><div class="food-emoji">🍽️</div><h3><?=e($r['name'])?></h3><p class="muted"><?=e($r['area'])?> · <?=e($r['address'])?></p><a class="btn" href="menu.php?id=<?=$r['id']?>">View menu</a></article><?php endforeach; ?><?php if(!$restaurants): ?><p>No restaurants available yet. Register a restaurant account and ask admin to approve it.</p><?php endif; ?></div>
<?php include 'partials/footer.php'; ?>
