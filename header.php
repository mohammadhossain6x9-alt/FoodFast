<?php
$flashData = $_SESSION['flash'] ?? null; unset($_SESSION['flash']);
?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($pageTitle ?? 'Food Fast') ?></title>
<link rel="stylesheet" href="assets/style.css">
</head><body>
<header class="topbar"><a class="brand" href="index.php">🍔 Food<span>Fast</span></a>
<nav>
<a href="index.php">Home</a>
<a href="restaurants.php">Restaurants</a>
<a href="cart.php">Cart (<?= cart_count() ?>)</a>
<?php if (logged_in()): ?>
<a href="<?= current_user()['role']==='admin'?'admin.php':(current_user()['role']==='restaurant'?'restaurant.php':'my_orders.php') ?>">Dashboard</a>
<a href="logout.php">Logout</a>
<?php else: ?><a href="login.php">Login</a><a class="nav-cta" href="register.php">Sign up</a><?php endif; ?>
</nav></header>
<main class="container">
<?php if ($flashData): ?><div class="alert <?= e($flashData['type']) ?>"><?= e($flashData['message']) ?></div><?php endif; ?>
