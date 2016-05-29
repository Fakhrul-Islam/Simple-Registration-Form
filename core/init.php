<?php
session_start();
include_once 'config.php';


function sanitize($name){
	return htmlspecialchars(trim($name));
}

function post_value($name){
	if( isset($_POST[$name]) && (!empty($_POST[$name])) ){
		return $_POST[$name];
	}else{
		return '';
	}
}

function deisplyError($error){
	$e = '<ul class="bg-danger">';
	foreach ($error as $error){
		$e .='<li class="text-danger">'.$error.'</li>';
	}
	$e .= '</ul>';
	return $e;
}

function query($query,$bindings,$conn){
	$result = $conn->prepare($query);
	$result->execute($bindings);
	return $result;
}

function queryAll($query,$bindings,$conn){
	$result = $conn->prepare($query);
	$result->execute($bindings);
	while($result = $result->fetchAll()){
		return $result;
	}
	
}

if( isset($_SESSION['USER_ID']) && !empty($_SESSION['USER_ID']) ){
	$userId = $_SESSION['USER_ID'];
	$loged_user = 'loged_user';
}elseif( isset($_COOKIE['kgka44sdfKJ']) && !empty($_COOKIE['kgka44sdfKJ']) ){
	$userId = $_COOKIE['kgka44sdfKJ'];
	$loged_user = 'loged_user';
}



?>