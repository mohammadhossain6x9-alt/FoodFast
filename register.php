<?php require 'config.php'; verify_csrf(); $error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $name=trim($_POST['name']??'');$email=trim($_POST['email']??'');$phone=trim($_POST['phone']??'');$pass=$_POST['password']??'';$role=$_POST['role']??'customer';
 if(!in_array($role,['customer','restaurant'],true)||!$name||!filter_var($email,FILTER_VALIDATE_EMAIL)||!$phone||strlen($pass)<6)$error='Please enter valid details. Password must be at least 6 characters.';
 else {try{$s=$pdo->prepare("INSERT INTO users(name,email,phone,password,role) VALUES(?,?,?,?,?)");$s->execute([$name,$email,$phone,password_hash($pass,PASSWORD_DEFAULT),$role]);$uid=(int)$pdo->lastInsertId();
 if($role==='restaurant'){$rs=$pdo->prepare("INSERT INTO restaurants(user_id,name,area,address,description) VALUES(?,?,?,?,?)");$rs->execute([$uid,trim($_POST['restaurant_name']??$name),trim($_POST['area']??'Local area'),trim($_POST['address']??''),trim($_POST['description']??'')]);}
 flash($role==='restaurant'?'Restaurant account created. Wait for admin approval.':'Account created. You can now log in.');redirect('login.php');
 }catch(PDOException $e){$error='This email is already registered.';}}
}
$pageTitle='Create account';include 'partials/header.php';?>
<div class="form-card"><h2>Create your account</h2><?php if($error):?><div class="alert error"><?=e($error)?></div><?php endif;?>
<form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<label>Full name</label><input name="name" required>
<label>Email</label><input type="email" name="email" required>
<label>Phone</label><input name="phone" required>
<label>Password (minimum 6 characters)</label><input type="password" name="password" minlength="6" required>
<label>Account type</label><select name="role" id="role" onchange="document.getElementById('restaurant-fields').hidden=this.value!=='restaurant'"><option value="customer">Customer</option><option value="restaurant">Restaurant owner</option></select>
<div id="restaurant-fields" hidden><label>Restaurant name</label><input name="restaurant_name"><label>Upazila / Area</label><input name="area" placeholder="Your upazila"><label>Full address</label><input name="address"><label>Description</label><textarea name="description"></textarea></div>
<div class="spacer"></div><button class="btn">Create account</button></form><p>Already registered? <a href="login.php">Login</a></p></div>
<?php include 'partials/footer.php'; ?>
