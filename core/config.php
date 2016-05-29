<?php
//Database Connection
$config = array(
	'DBNAME' =>'form',
	'DBUSERNAME' => 'root',
	'DBPASSWORD' => '',
);
$conn = connect($config);

function connect($config){
	try{
		$conn = new PDO("mysql:host=localhost;dbname=".$config['DBNAME'], 
						$config['DBUSERNAME'], $config['DBPASSWORD']);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn ;
	}catch(PDOException $e){
		return false;
	}
}



//CREATE TABLE
$user = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
	password VARCHAR(100) NOT NULL,
	country VARCHAR(20) NOT NULL,
	gender VARCHAR(2) NOT NULL,
	birthdate DATETIME NOT NULL,
	signup_date DATETIME NOT NULL,
	signup_ip VARCHAR(55) NOT NULL,
	last_login DATETIME NULL
 )";
if($conn->exec($user)){
	echo 'User table created';
}

?>