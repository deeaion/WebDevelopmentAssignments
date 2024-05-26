<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Problema 3</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 50%;
        }
        input, select {
            margin: 10px;
        }

        fieldset {
            margin: 10px;
            padding: 10px;
            border: 1px solid black;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<form style="display: inline;" action="logOut.php" method="POST">
    <input type="submit" value="Log Out">
</form>
<fieldset>
    <legend>Profesor</legend>

    <form method="post" action="functions.php">
        <label for="students">Students:</label>
        <select id="students" name="student_id" required>

            <?php
            require_once 'functions.php';
            $utils = new FunctionUtils();
            $students = $utils->GetStudents();
            foreach ($students as $student) {
                echo "<option value=\"{$student['id']}\">{$student['email']}</option>";
            }
            ?>
        </select>

        <label for="subjects">Subjects:</label>
        <select id="subjects" name="subject_id" required>
            <?php
            require_once 'functions.php';

            $utils = new FunctionUtils();
            $subjects = $utils->GetSubjects();
            foreach ($subjects as $subject) {
            echo "<option value=\"{$subject['id']}\">{$subject['name']}</option>";
            }
            ?>
        </select>

        <label for="grade">Grade:</label>
        <input id="grade" type="text" name="grade" required>

        <input type="submit" value="Submit Grade">
        <div>

        <?php
             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                 $student= $_POST['student_id'];
                 $grade = $_POST['grade'];
                 if($grade>10 || $grade<1){
                        echo 'Grade must be between 1 and 10';
                 }
                 $subject= $_POST['subject_id'];

                 $DBUtils = new DBUtils('labphp3');
                    $connection=$DBUtils->getPDO();
                    $result=$DBUtils->insert('grades','id_student,id_subject,grade',$student.','.$subject.','.$grade);

                    if($result){
                        echo 'Grade inserted';
                    }
                    else{
                        echo 'Grade not inserted';
                    }
            // Output the result within a specific HTML structure to avoid issues with echo

            $DBUtils->closeConnection();
        }
        ?>
        </div>

    </form>
</fieldset>
</body>
</html>
