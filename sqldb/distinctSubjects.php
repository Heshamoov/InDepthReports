<?php
        $servername = "localhost";          $username = "reports2018";
        $password = "Indepth2018";        $DB = "fedena_pro";

        $conn = new mysqli($servername, $username, $password, $DB);

        if ($conn->connect_error)
                die("Connection failed: " . $conn->connect_error . "\n");

        $grade = $_REQUEST["grade"];
//        $sql = "SELECT DISTINCT subject FROM gold WHERE grade = '$grade'";
       $sql = "SELECT  DISTINCT subjects.name subject_name \n"
    . "\n"
    . "FROM (((((( students\n"
    . "           INNER JOIN batches \n"
    . "           ON batches.id = students.batch_id)\n"
    . "           INNER JOIN courses \n"
    . "           ON batches.course_id = courses.id)\n"
    . "           INNER JOIN exam_groups\n"
    . "           ON exam_groups.batch_id = students.batch_id)\n"
    . "           INNER JOIN exam_scores \n"
    . "           ON exam_scores.student_id = students.id)\n"
    . "           INNER JOIN exams\n"
    . "           ON exams.id = exam_scores.exam_id)\n"
    . "           INNER JOIN subjects\n"
    . "           ON subjects.id = exams.subject_id)\n"
        . "WHERE courses.course_name = '$grade'";    

//      echo $sql;
        $result = $conn->query($sql);
    
        while($row = mysqli_fetch_array($result))
                echo $row['subject_name'] . "?";
        
        $conn->close();