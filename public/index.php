<?php
require_once '../core/initialize.php';
$user = 'guest';
if(!Login::verifySession()){
	Router::redirect('login');
}else{
	$sessionData = sanitize($_SESSION);
	$user = $sessionData['username'];
}
?>

<h1>Welcome, <?=ucfirst($user)?></h1>

<ul>
	<li><a href="update.php">Update Profile</a></li>
	<li><a href="logout.php">Log Out</a></li>
</ul>

