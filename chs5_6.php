<?php

require_once 'student.php';
require_once 'Grade.php';

$students = array();

$student1 = new Student("Kevin", "Slonka", "1001", array("CPSC222" => 98, "CPSC111" => 76, "CPSC333" => 82));
$student2 = new Student("Joe", "Schmoe", "1005", array("CPSC122" => 88, "CPSC411" => 46,  "CPSC345" => 72));
$student3 = new Student("Stewie", "Griffin", "1009", array("CPSC244" => 68, "CPSC116" => 96, "CPSC345" => 82));

$students[] = $student1;
$students[] = $student2;
$students[] = $student3;

echo "<h1><b>Chapters 5-6</b></h1>";

for ($i = 0; $i < count($students); $i++) {
	$student = $students[$i];
	echo "<table border='1'>
		<tr>
<td style='text-align: center;'><b>Name</b></td>
<td>{$student->getLastName()}, {$student->getFirstName()}</td>
</tr>
<tr>
<td style='text-align: center;'><b>Student ID</b></td>
<td>{$student->getStudentID()}</td>
</tr>
<tr>
<td style='text-align: center;'><b>Grades</b></td>
<td><ul>";
foreach ($student->getCourses() as $course => $grade) {
	$letterGrade = calculateLetterGrade($grade);
	echo "<li>{$course} - {$grade} {$lettergrade}</li>";
}
echo "</ul></td></tr></table><br/>";
}
?>
