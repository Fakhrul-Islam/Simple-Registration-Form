<?php
	include_once 'core/init.php';
	include_once 'inc/country_list.php';
	include_once 'inc/header.php';
	if( isset($loged_user) && $loged_user == 'loged_user' ){
		header('Location:admin');
	}
?>
<?php
	//Login
if(isset($_POST['login'])){

	$email = sanitize($_POST['log_email']);		 
	$password = sanitize($_POST['log_password']);
	$remember = (!empty($_POST['remember']))?sanitize($_POST['remember']):'';
	$error = '';
	$domain = ($_SERVER['HTTP_HOST'] != 'localhost')?$_SERVER['HTTP_HOST']:false;
	if( empty($email) || empty($password)){
		$error = 'Username or Email is Empty';
	}elseif(!empty($email)) {
		$query = query("SELECT * FROM users WHERE email = :email",array('email'=>$email),$conn);
		 if( $query->rowCount() == 0 ){
			$error = 'Email does\'nt match';
		}elseif ($query->rowCount()>0) {
			$user = $query->fetchAll();
			$hash = $user[0]['password'];
			if( !password_verify($password,$hash) ){
				$error = 'Password does\'nt match';
			}
		}
	}

	if( empty($error) ){
		$query = query("SELECT * FROM users WHERE email = :email",array('email'=>$email),$conn);
		$user = $query->fetchAll();
		$userId = $user[0]['id'];

		//SET SESSION
		$_SESSION['USER_ID'] = $userId;
		header('Location:admin');
		//SET COOKIE
		if(isset($remember) && $remember != ''){
			setcookie('kgka44sdfKJ',$userId,time()+60*86400,'/');
		}
		//PAGE REDIRECT
		
	}
}
?>
	<div class="container" style="margin-top:30px">
		<div class="row">
			<p class="bg-danger text-center"><?=(!empty($error))?$error:''; ?></p>
			<div class="col-md-12 navbar navbar-default">

				<form action="index.php" method="POST" id="login_form" class="form-inline" style="text-align:center;margin-top:7px">						
					 <div class="form-group">
					    <label for="log_email">Email</label>
					    <input type="email" class="form-control" id="log_email" placeholder="Email" name = "log_email" value="<?=sanitize(post_value('log_email'));?>">
					  </div>
					  <div class="form-group">
					    <label for="log_password">Password</label>
					    <input type="password" class="form-control" id="log_password" placeholder="Password" value="<?=sanitize(post_value('log_password'));?>" name="log_password">
					  </div>
					 <div class="checkbox">
					    <label>
					      <input type="checkbox" name="remember" value="remember"> Remember me
					    </label>
					  </div>
					  <button type="submit" name="login" class="btn btn-success">Log In</button>
				</form>

			</div>
		</div>
	</div>	
	<div class="container">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
			<h2 class="text-center">Simple Registration Form</h2>
			<p class="bg-success"><?php
				if(isset($_SESSION['success_flash']) && !empty($_SESSION['success_flash'])){
						echo $_SESSION['success_flash'];
						unset($_SESSION['success_flash']);
						$_SESSION['success_flash'] = '';
					}
			?></p>
			<form  method="POST" id="registration_form">
				<div class="form-group bg-danger" id="registraion_error"></div>
				<div class="form-group">
					<label for="first_name">First Name :</label>
					<input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo sanitize(post_value('first_name')); ?>">
				</div>
				<div class="form-group">
					<label for="last_name">Last Name :</label>
					<input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo sanitize(post_value('last_name')); ?>">
				</div>
				<div class="form-group">
					<label for="email">Email Address :</label>
					<input type="email" id="email" name="email" class="form-control" value="<?php echo sanitize(post_value('email')); ?>">
				</div>
				<div class="form-group">
					<label for="password">Password :</label>
					<input type="password" id="password" name="password" class="form-control" value="<?php echo sanitize(post_value('password')); ?>">
				</div>
				<div class="form-group">
					<label for="c_password">Confirm Password :</label>
					<input type="password" id="c_password" name="c_password" class="form-control" value="<?php echo sanitize(post_value('c_password')); ?>">
				</div>
				<div class="form-group">
					<label for="country">Country :</label>
					<select name="country" id="country" class="form-control">
						<option value=""> Select A Country</option>
						<?php foreach($countries as $countries) : ?>
							<option value="<?=$countries; ?>" <?= (post_value('country') == $countries)?'selected':'' ?> ><?=$countries; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="gender">Gender :</label>
					<select name="gender" id="gender" class="form-control">
						<option value="">I am..</option>
						<option value="m" <?= (post_value('gender') == 'm')?'selected':'' ?>>Male</option>
						<option value="f" <?= (post_value('gender') == 'f')?'selected':'' ?>>Female</option>
					</select>
				</div>
				<div class="form-group">
					<label for="birth_date">Birth Date :</label>
					<input type="text" id="birth_date" name="birth_date" class="form-control" value="<?php echo sanitize(post_value('birth_date')); ?>">
				</div>			
			</form>
				<button type="button" id="submit_button" onclick="submit();" class="btn btn-success pull-center">Submit</button>
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
<?php
	include_once 'inc/footer.php';	
?>