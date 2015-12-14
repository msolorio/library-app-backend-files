<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>0303 HTML Forms - php</title>
	<link rel="stylesheet" href="css/KingLib_8.css">
</head>
<body>
	<div id="logo-div">
		<a href="assignment_8.php"><img src="images/KingLibLogo.jpg" alt=""></a>
	</div>

	<?php
		include "assignment_8_common_functions.php";


		doValidation();

		/*
		if (!doValidation()) {
			addPatron();
		}
		*/

	?>

	<p>For Admin Use Only: <a href="assignment_8_view_patrons.php">View Patrons</a></p>

	<?php
		getServer();
	?>
</body>
</html>
