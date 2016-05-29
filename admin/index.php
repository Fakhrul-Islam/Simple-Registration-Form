<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/registration_form/core/init.php');
	if( $loged_user != 'loged_user'){
		header('Location:../index.php');		
	}
	$query = query("SELECT * FROM users WHERE id = :id",array('id'=>$userId),$conn);
	$user = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h2>Hello, <?php echo $user[0]['firstname']; ?></h2>
	<a href="logout.php">Logout</a>
</body>
</html>








