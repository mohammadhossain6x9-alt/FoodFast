<?php require 'config.php';verify_csrf();$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){$s=$pdo->prepare("SELECT * FROM users WHERE email=?");$s->execute([trim($_POST['email']??'')]);$u=$s->fetch();
if($u&&password_verify($_POST['password']??'',$u['password'])){session_regenerate_id(true);$_SESSION['user']=['id'=>(int)$u['id'],'name'=>$u['name'],'role'=>$u['role']];redirect('index.php');}else $error='Email or password is incorrect.';}
$pageTitle='Login';include 'partials/header.php';?>
<div class="form-card"><h2>Login to Food Fast</h2><?php if($error):?><div class="alert error"><?=e($error)?></div><?php endif;?><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><label>Email</label><input type="email" name="email" required><label>Password</label><input type="password" name="password" required><div class="spacer"></div><button class="btn">Login</button></form><p>New here? <a href="register.php">Create account</a></p></div>
<?php include 'partials/footer.php'; ?>
