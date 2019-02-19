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
        $category = $_REQUEST["category"];
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
//                . " AND (marks.Subject = '$subject') AND (marks.mark >= $min) $gender";\
        
//        
        if($category == '')
        {
    $sql = "SELECT students.first_name\n"
                . "FROM ((((((\n"
                . "    students   \n"
                . "    INNER JOIN batches ON students.batch_id = batches.id) \n"
                . "    INNER JOIN courses ON batches.course_id = courses.id) \n"
                . "    INNER JOIN exam_groups ON students.batch_id = exam_groups.batch_id) \n"
                . "    INNER JOIN exam_scores ON students.id = exam_scores.student_id) \n"
                . "    INNER JOIN exams ON exam_scores.exam_id = exams.id) \n"
                . "    INNER JOIN subjects ON exams.subject_id = subjects.id) \n"
                . "    WHERE ((exam_groups.name = '$term' ) AND (courses.course_name = '$grade') "
                . "    AND (subjects.name = '$subject') AND (exam_scores.marks >= $min )  $gender )";  
           
        }
        
        else {
          $sql = "SELECT students.first_name, student_categories.name\n"
                . "FROM (((((((\n"
                . "    students   \n"
                . "    INNER JOIN batches ON students.batch_id = batches.id) \n"
                . "    INNER JOIN courses ON batches.course_id = courses.id) \n"
                . "    INNER JOIN exam_groups ON students.batch_id = exam_groups.batch_id) \n"
                . "    INNER JOIN exam_scores ON students.id = exam_scores.student_id) \n"
                . "    INNER JOIN exams ON exam_scores.exam_id = exams.id) \n"
                . "    INNER JOIN subjects ON exams.subject_id = subjects.id) \n"
                . "    INNER JOIN student_categories ON students.student_category_id = student_categories.id)"
                . "    WHERE ((exam_groups.name = '$term' ) AND (courses.course_name = '$grade') "
                . "    AND (subjects.name = '$subject') AND (exam_scores.marks >= $min ) $category $gender )";     
        }
// echo $sql;
        
        $result = $conn->query($sql);
        $rowcount=mysqli_num_rows($result);
        echo $rowcount;

        $conn->close();