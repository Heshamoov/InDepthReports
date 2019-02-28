<?php
        include ('../dbConfig.php');

        $terms = $_REQUEST["terms"];
        $grades = $_REQUEST["grades"];
        $batches = $_REQUEST["batches"];
        $subjects = $_REQUEST["subjects"];
        $gender = $_REQUEST["gender"];
        $min = $_REQUEST["min"];
        $max = $_REQUEST["max"];
    
//        $sql =           " SELECT *" .
//                        " FROM gold" .
//                        " WHERE $terms $grades $batches $gender $subjects" .
//                        " AND (mark BETWEEN $min AND $max)";
   //   echo $sql;
                 if ($terms == "" and $grades == "" and $batches == "" and $gender == "" and $subjects == ""){

    $sql =    "SELECT students.admission_no moe, students.first_name name, students.gender gender,  batches.id, batches.name batch_name, \n"
            . "courses.id, courses.course_name grade, exam_groups.id examgroups_id, exam_groups.name exam_name, exam_scores.id examscores_id,\n"
            . " exam_scores.marks marks, exams.id exam_id, exams.subject_id, subjects.id subjects_id, subjects.name subject_name\n"
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
                 . " WHERE (exam_scores.marks BETWEEN $min AND $max)";}
            else{
        
        $sql =    "SELECT students.admission_no moe, students.first_name name, students.gender gender,  batches.id, batches.name batch_name, \n"
            . "courses.id, courses.course_name grade, exam_groups.id examgroups_id, exam_groups.name exam_name, exam_scores.id examscores_id,\n"
            . " exam_scores.marks marks, exams.id exam_id, exams.subject_id, subjects.id subjects_id, subjects.name subject_name\n"
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
            . "WHERE  $terms $grades $batches $gender $subjects AND (exam_scores.marks BETWEEN $min AND $max) ";
        
            }
//        echo $sql;
        $result = $conn->query($sql);
        $rowcount=mysqli_num_rows($result);
        echo $rowcount;

        $conn->close();