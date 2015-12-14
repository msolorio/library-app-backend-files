<html>
	<head>
		<title>CSWB150</title>
		<link rel="stylesheet" href="css/KingLib_8.css">
	</head>
	<body>
	<div id="grid-container">
		<div id="logo-div">
				<a href="assignment_8.php" target="_blank"><img src="images/KingLibLogo.jpg" alt=""></a>
			</div>
			<?php
				include "assignment_8_common_functions.php";
			?>
				<div id="featuredtitle">
					<p>Featured Title</p>
					<img src="images/book_children_of_men.jpg" alt="">
				</div>
		
				<div id="stafflist">
					<table>
						<tr>
							<td><img src="images/staff_lee.jpg" alt=""></td>
							<td><img src="images/staff_shirley.jpg" alt=""></td>
							<td><img src="images/staff_tom.jpg" alt=""></td>
						</tr>
					</table>
				</div>
		
				<div id="findtitle">
		
					<form method="post" action="assignment_8_booklist.php">
						<p>Enter KeyWord to Search for Titles:</p>
						<p><input type="text" size="30" name="keyword"><br/>
									(leave blank to list all titles)</p>
						<input type="submit" value="Find Titles">
					</form>
		
				</div>
		
				<div id="logon">
		
					<form method="post" action="assignment_8_logon.php">
						<p>Logon to your Account</p>
						<p><label>User Id:</label> <input type="text" name="userid" size="11"><br/>
						<label>Password:</label> <input type="text" name="password" size="11"></p>
						<p><input type="submit" value="Logon"> <a href="assignment_8_register.php" target="_blank">Click to Register</a></p>
					</form>
				</div>
			</div>
			<?php
				getServer();
			?>
	</body>
</html>