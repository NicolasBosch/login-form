<?php
require_once '../core/initialize.php';

$msj = '';
$errors = '';

if(Login::verifySession()){
	Router::redirect('index');
}
if($requestMethod == 'POST' && isset($_POST['login'])){
	unset($_POST['login']);
	$inputs = sanitize($_POST);
	$errors = validate($inputs);
	if(!$errors){
		$login = new Login();
		if(!$login->verifyLogin($inputs)){
			$msj = $login->getError();
		}else{
			Router::redirect('index');
		}
	}
}

?>

<p><?= $msj ?></p>
<h3>Sign in</h3>

<form action="" method="post">
	<div>
		<label for="username">Username: </label>
		<input type="text" name="username" id="username" autocomplete="off" value="<?= isset($inputs)?$inputs['username']:''?>" required>
		<div><?=displayErrors($errors,'username')?></div>
	</div>
	<div>
		<label for="password">Password: </label>
		<input type="password" name="password" id="password" required>
		<div><?=displayErrors($errors,'password')?></div>
	</div>

	<input type="submit" value="Sign in" name="login">
</form>