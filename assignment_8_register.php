<html>
	<head>
		<title>CSWB150</title>
		<link rel="stylesheet" href="css/KingLib_8.css">
	</head>
	<body>
		<div id="logo-div">
			<a href="assignment_8.php"><img src="images/KingLibLogo.jpg" alt=""></a>
		</div>
		<div id="form-div">
			<form method="post" action="assignment_8_add_patron.php">
				<p>Please sign up</p>
				
				<p>First Name:<br/>
				<input type="text" name="firstname" size="30"></p>
	
				<p>Last Name:<br/>
				<input type="text" name="lastname" size="30"></p>
	
				<p>Email:<br/>
				<input type="text" name="email" size="40"></p>

				<p>Birth Year:<br/>
				<input type="text" name="birthyear" size="4"></p>
	
				<?php
					include "assignment_8_common_functions.php";					
				?>

				<p>City of Residence:<br/>
					<select name="city" id="" size="1">
						<option value="-"></option>
						<?php
							populateCityList();
						?>
					</select>
				</p>

				<p>Choose Userid and Password<br/>
				(10 character maximum):</p>
				
				<p>UserId: <input type="text" name="userid" size="10"> Password: <input type="text" name="password" size="10"></p>

				<p><input type="submit" name="addpatron" value="Submit Information"></p>
				<p>For Admin Use Only: <a href="assignment_8_view_patrons.php">View Patrons</a></p>

				<?php
					getServer();
				?>
			</form>
		</div>
	</body>
</html>
