<!DOCTYPE html>
<html>
<head>
<title>Birthday Formatter</title>
</head>
<body>
<h1>Birthday Formatter</h1>
<?php

function sanitizeInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function getSuffix($number) {
	if ($number % 100 >= 11 && $number % 100 <= 13) {
		return 'th';
	}
	switch ($number % 10) {
	case 1: return 'st';
	case 2: return 'nd';
	case 3: return 'rd';
	default: return 'th';
	}
}

function formatBirthday($month, $day, $year, $hour, $minute, $ampm) {
	$time_format = "H:i";
	if ($ampm == "PM" && $hour != 12) {
		$hour += 12;
	}
	elseif ($ampm == "AM" && $hour == 12) {
		$hour = 0;
	}

	$day_suffix = getSuffix($day);

	$birthday_time = sprintf("%04d-%02d-%02d %02d:%02d", $year, $month, $day, $hour, $minute);
	$date = new DateTime($birthday_time);
	return $date->format('F js, Y - g:ia');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$user_month = sanitizeInput($_POST["month"]);
	$user_day = sanitizeInput($_POST["day"]);
	$user_year = sanitizeInput($_POST["year"]);
	$user_hour = sanitizeInput($_POST["hour"]);
	$user_minute = sanitizeInput($_POST["minute"]);
	$user_ampm = sanitizeInput($_POST["ampm"]);

	$date =  new DateTime("$user_year-$user_month-$user_day");
	$weekday = $date->format('l');

	$pretty_birthday = formatBirthday($user_month, $user_day, $user_year, $user_hour, $user_minute, $user_ampm);

	echo "<p>$weekday $pretty_birthday</p>";

	$iso_birthday = str_replace("-", "", $pretty_birthday);

	echo "<p><a href='?formatted_date=".urlencode($iso_birthday)."&format=iso'>Show date in ISO format</a></p>";
}
elseif (isset($_GET["formatted_date"])) {
	$user_birthday = sanitizeInput($_GET["formatted_date"]);

	if(isset($_GET["format"]) && $_GET["format"] === "iso") {
		$date = new DateTime($user_birthday);
		$iso_formatted_date = $date->format('Y-m-d H:i:s');
		echo "<p>$iso_formatted_date</p>";
	}
	else{ echo "<p>$user_birthday</p>";
	}
} else {
?>
	<form method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
<table border="1">
<tr>
<th>Month</th>
<th>Day</th>
<th>Year</th>
<th>Hour</th>
<th>minute</th>
<th>AM/PM</th>
</tr>
<tr>
<td>
<select name='month' required>
<option value ='1'>January</option>
<option value ='2'>February</option>
<option value ='3'>March</option>
<option value='4'>April</option>
<option value='5'>May</option>
<option value='6'>June</option>
<option value='7'>July</option>
<option value='8'>August</option>
<option value '9'<September</option>
<option value '10'<October</option>
<option value '11'<November</option>
<option value '12'<December</option>
</select>
</td>
<td>
<select name='day' required>
<?php
	for($i = 1; $i <= 31; $i++) {
		echo "<option value='$i'>$i</option>";
	}
?>
</select>
</td>
<td>
<select name='year' required>
<?php
	$currentYear = date("Y");
	for($i = $currentYear; $i >= 1900; $i--) {
		echo "<option value='$i'>$i</option>";
	}
?>
</select>
</td>
<td>
<select name='hour' required>
<?php
	for($i = 1; $i <= 12; $i++) {
		echo "<option value='$i'>$i</option>";
	}
?>
</select>
</td>
<td>
<select name='minute' required>
<?php
	for($i = 0; $i <= 59; $i++) {
		$minute = ($i <10) ? "0$i" : $i;
		echo "<option value= '$minute'>$minute</option>";
	}
?>
</select>
</td>
<td>
<select name='ampm' required>
<option value='AM'>AM</option>
<option value='PM'>PM</option>
</select>
</td>
</tr>
<tr>
<td colspan="6" style="text-align: center;">
<input type="submit" value="Format Date">
</td>
</tr>
</table>
</form>
<?php} ?>
</body>
</html>
