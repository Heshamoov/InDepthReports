<?php
        include ('../dbConfig.php');

$grades = $_REQUEST["grades"];
        $batches = $_REQUEST["batches"];
        $subjects = $_REQUEST["subjects"];
        $gender = $_REQUEST["gender"];
        $terms = $_REQUEST["terms"];
    
//       $sql =       " SELECT students.admission_no, students.first_name, students.gender," .
//                        " marks.Exam_Group, marks.Grade, marks.Batch, marks.Subject, marks.Mark " .
//                        " FROM marks" .
//                        " INNER JOIN students ON students.admission_no = marks.MOE" .
//                        " WHERE $terms $grades $batches $gender $subjects";
//       echo $sql;
         if ($terms == "" and $grades == "" and $batches == "" and $gender == "" and $subjects == ""){

    $sql =    "SELECT *"
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
            . "ON subjects.id = exams.subject_id)\n "; }
            
            else{
        
        $sql =    "SELECT*"
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
            . "WHERE  $terms $grades $batches $gender $subjects";
            }
        
//        echo $sql;
        
        $result = $conn->query($sql);
        $rowcount=mysqli_num_rows($result);
        echo $rowcount;
        
        $conn->close();
