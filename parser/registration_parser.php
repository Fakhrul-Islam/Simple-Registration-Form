<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/registration_form/core/init.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
	$query = queryAll("SELECT * FROM users",array(),$conn);
	$first_name = sanitize($_POST['first_name']);
	$last_name = sanitize($_POST['last_name']);
	$email = sanitize($_POST['email']);
	$password = sanitize($_POST['password']);
	$hash_pass = password_hash($password,PASSWORD_BCRYPT);
	$confirm_password = sanitize($_POST['c_password']);
	$country = sanitize($_POST['country']);
	$gender = sanitize($_POST['gender']);
	$birth_date = sanitize($_POST['birth_date']);
	$ip = $_SERVER['REMOTE_ADDR'];
	$error = array();
	$form_data = array(
			'First_Name' 		=> $first_name,
			'Last_Name' 		=> $last_name,
			'Email' 			=> $email,
			'Password' 			=> $password,
			'Confirm_Password' 	=> $confirm_password,
			'Country' 			=> $country,
			'Gender' 			=> $gender,
			'Date_of_Birth' 	=> $birth_date
	);

	if( $password != $confirm_password ){
		$error[] = 'Sorry Password not match';
	}
	if(strlen($password) < 6 ){
		$error[] = 'Password must be at least 6 characters';
	}
	if( !filter_var($email,FILTER_VALIDATE_EMAIL) ){
		$error[] = 'Your email is not valid';
	}
	if( !empty($email)){
		foreach($query as $query){
			if ($email == $query['email']){
				$error[] = 'Email Already Taken';
			}
		}
	}
	
	foreach($form_data as $key => $value){
		if( empty($value) || $value == ''){
			$error[] = $key.' is Empty';
		}
	}

	if(!empty($error)){
		echo deisplyError($error);
	}else{
		$insert = query('INSERT INTO users(firstname,lastname,email,password,country,gender,birthdate,signup_date,signup_ip) VALUES(:firstname,:lastname,:email,:hash,:country,:gender,:birthdate,now(),:ip)',array(
					'firstname' 	=> $first_name,
					'lastname' 		=> $last_name,
					'email' 		=> $email,
					'hash' 			=> $hash_pass,
					'country' 		=> $country,
					'gender' 		=> $gender,
					'birthdate'		=> $birth_date,
					'ip' 			=> $ip,
			),$conn);
		if($insert){
			 $_SESSION['success_flash'] ="Registration Success";
			echo 'passed';
		}
	}

}

?>