<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//hard coded
$employeeName = "James Parmelee"; //name
$hours = 40.0; //weekly hours worked
$payRate = 54.50; //pay rate by hour
$federalTax = 0245; //federal tax rate
$stateTax = 0.055; //state tax rate

//calc
$grossPay = $hours * $payRate;
$federalWithhold = $grossPay * $federalTax;
$stateWithhold = $grossPay * $stateTax;
$totalDeduction = $federalWithhold + $stateWithhold;
$netPay = $grossPay - $totalDeduction;

$annualPay = $grossPay * 52;

//formatting
$hours = number_format($hours, 2);
$payRate = number_format($payRate, 2);
$grossPay = number_format($grossPay, 2);
$federalWithhold = number_format($federalWithhold, 2);
$stateWithhold = number_format($stateWithhold, 2);
$totalDeduction = number_format($totalDeduction, 2);
$netPay = number_format($netPay, 2);

//tax bracket
$federalBracket = "";
if ($annualPay <= 11600) {
	$federalBracket = "10%";
}
elseif($annualPay >= 11601 && $annualPay <= 47150) {
	$federalBracket = "12%";
}
elseif($annualPay >= 47151 && $annualPay <= 100525) {
	$federalBracket - "22%";
}
elseif($annualPay >= 100526 && $annualPay <= 191950) {
	$federalBracket = "24%";
}
elseif($annualPay >= 191951 && $annualPay <= 243725) {
	$federalBracket = "32%";
}
elseif($annualPay >= 243726 && $annualPay <= 609250) {
	$federalBracket = "35%";
}
else {
	$federalBracket = "37%";
}

//output
echo "<table>";
echo "<tr><th>Employee Name</th><td>$employeeName</td></tr>";
echo "<tr><th>Hours Worked</th><td>$hours</td></tr>";
echo "<tr><th>Pay Rate</th><td>\$$payRate</td></tr>";
echo "<tr><th>Gross Pay</th><td>\$$grossPay</td></tr>";
echo "<tr><th>Federal Withholding (24.5%)</th><td>\$$federalWithhold</td></tr>";
echo "<tr><th>State Withholding (5.5%)</th><td>\$$stateWithhold</td></tr>";
echo "<tr><th>Total Deductions</th><td>\$$totalDeduction</td></tr>";
echo "<tr><th>NetPay</th><td>\$$netPay</td></tr>";
echo "<tr><th>Federal Tax Bracket</th><td>$federalBracket</td></tr>";
echo "</table>";
?>
