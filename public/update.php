<?php
require '../core/initialize.php';
$msj = '';
if(!Login::verifySession()){
	Router::redirect('login');
}
if($requestMethod === 'POST'){
	$inputs = sanitize($_POST);
	$errors = validate($inputs);
	if(!$errors){
		$user = new User(sanitize($_SESSION['id']));
		if(isset($_POST['chg_email'])){
			$email = sanitize($inputs['email']);
			if(!$user->update(['email'],[$email])){
				$msj = 'Email could not be changed';
			}else{
				$msj = 'Email changed successfully';
			}
		}elseif(isset($_POST['chg_password'])){
			$password = sanitize($inputs['password']);
			if(!password_verify($inputs['password_old'],$user->getPassword())){
				$msj = 'Password doesnt match';
			}else{
				if(!$user->update(['password'],[password_hash($password,PASSWORD_DEFAULT)])){
					$msj = 'Password could not be changed';
				}else{
					$msj = 'Password changed successfully';
				}
			}
		}
	}
}else{$errors = '';$msg = '';}

?>
<div><?=$msj?></div>
<form action="" method="post">
	<div>
		<label for="email">New Email:</label>
		<input type="email" name="email" id="email" autocomplete="off" value="<?= isset($inputs['email'])?$inputs['email']:''?>" required>
		<div><?= displayErrors($errors,'email') ?></div>
	</div>
	<div>
		<label for="email_repeat">Repeat new Email:</label>
		<input type="email" name="email_repeat" id="email_repeat" autocomplete="off" value="<?= isset($inputs['email_repeat'])?$inputs['email_repeat']:''?>" required>
		<div><?= displayErrors($errors,'email_repeat') ?></div>
	</div>
	<input type="submit" value="Change Email" name="chg_email">
</form>

<form action="" method="post">
	<div>
		<label for="password_old">Current Password: </label>
		<input type="password" name="password_old" id="password_old" required>
		<div><?= displayErrors($errors,'password_old') ?></div>
	</div>
	<div>
		<label for="password">New Password: </label>
		<input type="password" name="password" id="password" required>
		<div><?= displayErrors($errors,'password') ?></div>
	</div>
	<div>
		<label for="password_repeat">Repeat New Password: </label>
		<input type="password" name="password_repeat" id="password_repeat" required>
		<div><?= displayErrors($errors,'password_repeat') ?></div>
	</div>
	<input type="submit" value="Change Password" name="chg_password">
</form>

<ul>
	<li><a href="index.php">Back to main page</a></li>
	<li><a href="logout.php">Log Out</a></li>
</ul>