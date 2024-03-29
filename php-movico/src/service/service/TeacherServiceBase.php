<?php
class TeacherServiceBase {

	public function createTeacher($pk=0) {
		return $this->getPersistence()->create($pk);
	}

	public function getTeacher($pk) {
		return $this->getPersistence()->findByPrimaryKey($pk);
	}

	public function updateTeacher(Teacher $object) {
		return $this->getPersistence()->update($object);
	}

	public function deleteTeacher($pk) {
		$this->getPersistence()->remove($pk);
	}

	public function getTeachers($from=0, $limit=9999999999) {
		return $this->getPersistence()->findAll($from, $limit);
	}

	public function countTeachers() {
		return $this->getPersistence()->count();
	}

	private function getPersistence() {
		return Singleton::create("TeacherPersistence");
	}

	public function findByStudentId($studentId, $from, $limit) {
		return $this->getPersistence()->findByStudentId($studentId, $from, $limit);
	}

	public function setStudents($teacherId, $studentIds) {
		$this->getPersistence()->setStudents($teacherId, $studentIds);
	}

}
?>