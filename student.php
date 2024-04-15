<?php

class Student {
	private $firstName;
	private $lastName;
	private $studentID;
	private $courses;

	public function __construct($firstName, $lastName, $studentID, $courses) {
		$this->setFirstName($firstName);
		$this->setLastName($lastName);
		$this->setStudentID($studentID);
		this->setCourses($courses);
	}

	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}
	public function getFirstName() {
		return $this->firstName;
	}
	public function setLastName($lastname) {
		$this->lastName = $lastName;
	}
	public function getLastName() {
		return $this->lastName;
	}
	public function setStudentID($studentID) {
		$this->studentID = $studentID;
	}
	public function getStudentID() {
		return $this->studentID;
	}
	public function setCourses($courses) {
		$this->Courses = $courses;
	}
	public function getCourses() {
		return $this->courses;
	}
}

?>
