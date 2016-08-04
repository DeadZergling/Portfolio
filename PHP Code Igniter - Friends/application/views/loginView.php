<!DOCTYPE html>
<html>
<head>
	<title>Login, Registration, and Bears.</title>
	<style type="text/css">
		*
{
 margin: 0px;
 padding: 0px;
}
/*Base Container*/
		#wrapper{
			width: 930px;
			margin: 0px auto;
		}
		.login
		{
			height:150px;
			width:450px;
			border: 2px solid black;
			display: inline-block;
			margin-left: 15px;
		}
		.register
		{
			height:350px;
			width:450px;
			border: 2px solid black;
			display: inline-block;
			vertical-align: top;
		}
		.login input
		{
			margin-bottom:5px;
		}
		.register input
		{
			margin-bottom:5px;
		}
	</style>
</head>
<body>
	<div id='wrapper'>
		<div class='register'>
			<h4>Register</h4><br>
			<form action='../Friends/register' method='post'>
				<label>
					Name:   <input style='margin-left:81px;' type="text" name="name" value=<?php echo '\'' . $this->session->flashdata('name') . '\''?> required><br>
				</label>
				<label>
					Alias:   <input style='margin-left:85px;' type="text" name="alias" value=<?php echo '\'' . $this->session->flashdata('alias') . '\''?> required><br>
				</label>
				<label>
					Email:   <input style='margin-left:80px;' type="text" name="email" value=<?php echo '\'' . $this->session->flashdata('registeremail') . '\''?> required><br>
				</label>
				<label>
					Password:   <input style='margin-left:58px;' type="password" name="password"><br>
				</label>
				<label>
					Confirm Password:   <input type="password" name="Confirm Password"><br>
				</label>
				<label style='vertical-align: top;'>
				Date of Birth:   <input style='margin-left:35px;width:130px;' type="date" name="dateofbirth" value=<?php echo '\'' . $this->session->flashdata('dateofbirth') .'\'' ?> required><br><br>
				</label>
				<input type="submit" value="Register" style='font-size:18px;color:white;background-color:green;border:2px solid black; margin-left: 250px;'>
			</form>
			<?php echo $this->session->flashdata('errors'); 
				  echo $this->session->flashdata('dateofbirthbad');
			?>
		</div>
		<div class='login'>
			<h4>Log In</h4><br><br>
			<form action='../Friends/login' method='post'>
				<label>
					Email:   <input type="text" style='margin-left:69px;' name="email" value=<?php echo '\'' . $this->session->flashdata('loginemail') . '\''?> required><br>
				</label>
				<label>
					Password:   <input style='margin-left: 46px;' type="password" name="password"><br><br>
				</label>
				<input type="submit" value="Login" style='font-size:18px;color:white;background-color:green;border:2px solid black; margin-left: 250px;'>
			</form>
			<?php 
				if($this->session->userdata('usernamenotfound') == true)
				{
					$this->session->set_userdata('usernamenotfound', false);
					echo '<h3 style=\'color:red;\'>Incorrect Email and/or password.</h3>';
				}
			 ?>
		</div>
	</div>
</body>
</html>