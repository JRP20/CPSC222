<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewpoint" content="width=content-width, initial-scale=1.0">
<title>PHP Ch 13</title>
</head>

<body>
<?php
session_start();

function cleanInput($data) {
	return preg_replace('/[^\w\s]/', '', $data);
}

if(isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
	echo "<h2>Hello, $username</h2>";
	echo "<p><a href='logout.php'>Logout</a></p>";
}

else{
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = cleanInput($_POST['username']);
		$password = cleanInput($_POST['password']);

		if($username === "admin" && $password ==="password") {
			$_SESSION['username'] = $username;
			header("location: ".$SERVER['PHP_SELF']);
			exit();

		}

		else{
			$errormessage = "Invalid Login...";
		}
	}

	if(isset($errormessage)) {
		echo "<p>$errormessage</p>";
	}

	echo "<form method='post'>";
	echo "<label for='username'>Username' name='username'><br>";
	echo "<input type='text' id='username' name='username'><br>";
	echo "label for='password'>Password: </label>";
	echo "<input type=;password' id='password' name='password'><br>";
	echo "<input type='submit' value='Login'>";
	echo "</form>";
}

?>
</body>
</html>
