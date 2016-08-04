<!DOCTYPE html>
<html>
<head>
	<title>Welcome to the Wish List Viewer</title>
	<style type="text/css">
	.one
	{
		display:inline-block;
		vertical-align: top;
		font-weight: bold;
	}
	.two
	{
		display:inline-block;
		vertical-align: top;
		margin-left:550px;
	}
	.three
	{
		display:inline-block;
		vertical-align: top;
		margin-left:650px;
	}
	.userinfo
	{
		vertical-align: top;
	}
	.itemtitle
	{
		font-weight: bold;
		font-size: 21px;
	}
	</style>
	
</head>
<body>
	<div style='height:60px;'>
			<a style='margin-left:500px;' href="/Friends/index/">Home</a> | <a href="/Friends/logout">Logout</a>
	</div>
	 <div class='userinfo'>
		<?php  
			echo "<h2>" . $userinfo->alias . "'s Profile</h2><br>";
			echo "<p>Name: " . $userinfo->name . "</p><br>";
			echo "<p>Email Address: " . $userinfo->email . "</p>";
		?>
	 </div>
</body>
</html>