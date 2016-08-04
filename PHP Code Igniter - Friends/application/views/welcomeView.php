<!DOCTYPE html>
<html>
<head>
	<title>Welcome to the Friends Viewer</title>
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
	.myfriendslist
	{
		vertical-align: top;
	}
	</style>
	
</head>
<body>
	<div style="height:45px;">
		<?php 
			echo '<p class=\'one\'>Welcome ' . $this->session->userdata('name') . '!</p>';
		 ?>
		 <a class='two' href='/Friends/logout/'>Log Out</a>
	 </div>
	 <div class='myfriendslist'>
	 	 	<h3>Your Friends</h3>
					<?php
						if($myfriends != null)
						{
							echo "	<table>
										<thead>
											<tr>
												<th>Alias</th>
												<th>Action</th>
											</tr>
										</thead>
									<tbody>";
							foreach ($myfriends as $friend) 
							{				
								echo "<tr>
										<td>". $friend['friend_alias'] . "</td>
										<td><a href=/Friends/userinfo/" . $friend['friend_id'] . ">View Profile</a>
										<a href=/Friends/removefriend/" . $friend['friend_id'] . ">Remove as Friend</a></td>	
									 </tr>";
							}
						}
						else
						{
							echo "<h2>You don't have friends, yet.</h2>";
						}
					?>
				</tbody>
			</table>
	 </div>
	 <div class='wishlistothers'>
	 	 	<h3>Your NOT Friends</h3>
	 		<table>
				<thead>
					<tr>
						<th>Alias</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if($notfriends != null)
						{
							foreach ($notfriends as $friend) 
							{				
								echo "<tr>
										<td><a href=/Friends/userinfo/" . $friend['friend_id'] . ">" . $friend['friend_alias'] . "</a></td>
										<td><form action='/Friends/addFriend' method='post'>
										<input type=\"hidden\" name=\"id\" value=\"". $friend['friend_id'] . "\">
										<input type=\"submit\" value=\"Add as Friend\" style='font-size:18px;color:white;background-color:green;border:2px solid black; margin-left: 75px;'></form></td>	
									 </tr>";
							}
						}
					?>
				</tbody>
			</table>
	 </div>
</body>
</html>