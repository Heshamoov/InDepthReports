<?php
        $servername = "localhost";          $username = "reports2018";
        $password = "Indepth2018";        $DB = "fedena_pro";

        $conn = new mysqli($servername, $username, $password, $DB);

        if ($conn->connect_error)
                die("Connection failed: " . $conn->connect_error . "\n");

        
        $term = $_REQUEST["term"];
        $grade = $_REQUEST["grade"];
        $subject = $_REQUEST["subject"];
        $gender = $_REQUEST["gender"];
        $min = $_REQUEST["min"];
        
        
        if ($gender === 'Both')
                $gender = "";
        else if ($gender === 'Boys') 
                $gender = " AND (students.Gender = 'm') ";
        else if ($gender === 'Girls')
                $gender = " AND (students.Gender = 'f') ";
                    

        
//        $sql = "SELECT students.Gender, marks.Mark FROM marks\n"
//
//    . "INNER JOIN students ON students.admission_no = marks.MOE\n"
//
//    . "WHERE (marks.Exam_Group = '$term') AND (marks.Grade = '$grade')"
//                . " AND (marks.Subject = '$subject') AND (marks.mark >= $min) $gender";
        
          $sql = "SELECT students.gender gender,\n"
            . "exam_scores.marks marks"
            . "\n"
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
            ."WHERE (exam_groups.name = '$term' ) AND (courses.course_name = '$grade' "
            . "AND (subjects.name = '$subject') AND (exam_scores.marks >= $min ) $gender )";     

// echo $sql;
        
        $result = $conn->query($sql);
        $rowcount=mysqli_num_rows($result);
        echo $rowcount;

        $conn->close();