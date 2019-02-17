<?php
        $servername = "localhost";          $username = "reports2018";
        $password = "Indepth2018";        $DB = "fedena_pro";

        $conn = new mysqli($servername, $username, $password, $DB);

        if ($conn->connect_error)
                die("Connection failed: " . $conn->connect_error . "\n");

        $terms = $_REQUEST["terms"];
        $grades = $_REQUEST["grades"];
        $batches = $_REQUEST["batches"];
        $subject = $_REQUEST["subject"];
        $gender = $_REQUEST["gender"];
        $min = $_REQUEST["min"];
        $max = $_REQUEST["max"];
        
        if ($terms == "" and $grades == "" and $batches == "" and $gender == "" ) {
//                $sql =       " SELECT *" .
//                                " FROM gold" .
//                                " WHERE subject LIKE '$subject%'" .
//                                " AND (mark BETWEEN $min AND $max)";
            $sql =    "SELECT * "
            . "FROM (((((("
            . "students\n"
            . "INNER JOIN batches \n"
            . "ON batches.id = students.batch_id)\n"
            . "\n"
            . "INNER JOIN courses \n"
            . "ON batches.course_id = courses.id)\n"
            . "\n"
            . "INNER JOIN exam_groups\n"
            . "ON exam_groups.batch_id = students.batch_id)\n"
            . "\n"
            . "INNER JOIN exam_scores \n"
            . "ON exam_scores.student_id = students.id)\n"
            . "\n"
            . "INNER JOIN exams\n"
            . "ON exams.id = exam_scores.exam_id)\n"
            . "\n"
            . "INNER JOIN subjects\n"
            . "ON subjects.id = exams.subject_id)\n "
            . " WHERE subjects.name LIKE '$subject%'" 
            ." AND (exam_scores.marks BETWEEN $min AND $max)";
            
        } else {
//              $sql =       " SELECT *" .
//                                " FROM gold" .
//                                " WHERE $terms $grades $batches $gender AND subject LIKE '$subject%'" .
//                                " AND (mark BETWEEN $min AND $max)";
            
            $sql =    "SELECT * "
            . "FROM (((((("
            . "students\n"
            . "INNER JOIN batches \n"
            . "ON batches.id = students.batch_id)\n"
            . "\n"
            . "INNER JOIN courses \n"
            . "ON batches.course_id = courses.id)\n"
            . "\n"
            . "INNER JOIN exam_groups\n"
            . "ON exam_groups.batch_id = students.batch_id)\n"
            . "\n"
            . "INNER JOIN exam_scores \n"
            . "ON exam_scores.student_id = students.id)\n"
            . "\n"
            . "INNER JOIN exams\n"
            . "ON exams.id = exam_scores.exam_id)\n"
            . "\n"
            . "INNER JOIN subjects\n"
            . "ON subjects.id = exams.subject_id)\n "
            . " WHERE $terms $grades $batches $gender AND subjects.name LIKE '$subject%'" 
            . " AND (exam_scores.marks BETWEEN $min AND $max)";
                    
        }
//       echo $sql;
        
        $result = $conn->query($sql);
        $rowcount=mysqli_num_rows($result);
        echo $rowcount;

        $conn->close();