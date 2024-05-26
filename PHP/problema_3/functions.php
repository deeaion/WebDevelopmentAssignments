<?php
require_once '../dBUtils.php';

class FunctionUtils
{
    public static function GetStudents()
    {

        $DBUtils = new DBUtils('labphp3');
        $connection = $DBUtils->getPDO();
        $result = $DBUtils->select('students', 'id,email','1');
        echo $result;
        $students = [];
        foreach ($result as $student) {
            $students[] = $student;
        }
        return $students;
    }
    public static function GetProfessors()
    {

        $DBUtils = new DBUtils('labphp3');
        $connection = $DBUtils->getPDO();
        $result = $DBUtils->select('teacher', '*','1');
        echo $result;
        $professors = [];
        foreach ($result as $professor) {
            $professors[] = $professor;
        }
        return $professors;
    }
    public static function GetSubjects()
    {

        $DBUtils = new DBUtils('labphp3');
        $connection = $DBUtils->getPDO();
        $result = $DBUtils->select('subject', '*','1');
        $subjects = [];
        foreach ($result as $subject) {
            $subjects[] = $subject;
        }
        return $subjects;
    }
    public static function SearchUsers($stringToSearch)
    {
        $DBUtils = new DBUtils('labphp3');
        $connection = $DBUtils->getPDO();
        $result = $DBUtils->select('students', 'email', 'email LIKE "%'.$stringToSearch.'%"');
        $students = [];
        foreach ($result as $student) {
            $students[] = $student;
        }
        return $students;
    }
}

