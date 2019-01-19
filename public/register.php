<?php
require_once '../core/initialize.php';
if(Login::verifySession()){
	Router::redirect('index');
}

$errors = '';
$msj = '';

if($requestMethod == 'POST' && isset($_POST['register'])){
	unset($_POST['register']);
	$inputs = sanitize($_POST);
	$errors = validate($inputs);
	if(!$errors){
		$user = new User();
		if($user->register($inputs)){
			$msj = 'User registered successfully!';
			unset($inputs);
		}else{
			$msj = $user->getError();
		}
	}
}

?>

<h3>Register User</h3>

<p><?=$msj?></p>
<form action="" method="post">
	<div>
		<label for="username">Username: </label>
		<input type="text" name="username" id="username" autocomplete="off" value="<?= isset($inputs)?$inputs['username']:''?>" required>
		<div><?= displayErrors($errors,'username') ?></div>
	</div>
	<div>
		<label for="email">Email:</label>
		<input type="email" name="email" id="email" autocomplete="off" value="<?= isset($inputs)?$inputs['email']:''?>" required>
		<div><?= displayErrors($errors,'email') ?></div>
	</div>
	<div>
		<label for="password">Password: </label>
		<input type="password" name="password" id="password" required>
		<div><?= displayErrors($errors,'password') ?></div>
	</div>
	<div>
		<label for="password_repeat">Repeat Password: </label>
		<input type="password" name="password_repeat" id="password_repeat" required>
		<div><?= displayErrors($errors,'password_repeat') ?></div>
	</div>
	<input type="submit" value="Register" name="register">
</form>