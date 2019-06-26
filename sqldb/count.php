<?php

include ('../config/dbConfig.php');

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
if ($terms == "" and $grades == "" and $batches == "" and $gender == "" and $subjects == "") {

   $sql = "SELECT students.admission_no moe, students.first_name name, students.gender gender, batches.name batch_name, courses.course_name grade,exam_groups.name exam_name, exam_scores.marks marks,subjects.name subject_name\n"
            . "\n"
            . "FROM ((((((\n"
            . "students\n"
            . "INNER JOIN batches ON students.batch_id = batches.id) \n"
            . "	INNER JOIN courses ON batches.course_id = courses.id)     \n"
            . "	INNER JOIN exam_groups ON students.batch_id = exam_groups.batch_id)\n"
            . "	INNER JOIN exams ON exam_groups.id = exams.exam_group_id)    \n"
            . "	INNER JOIN exam_scores\n"
            . "	ON students.id = exam_scores.student_id\n"
            . "       AND exam_scores.exam_id = exams.id)\n"
            . "	INNER JOIN subjects ON exams.subject_id = subjects.id) ";
} else {

   $sql = "SELECT students.admission_no moe, students.first_name name, students.gender gender, batches.name batch_name, courses.course_name grade,exam_groups.name exam_name, exam_scores.marks marks,subjects.name subject_name\n"
            . "FROM ((((((\n"
            . "students\n"
            . "INNER JOIN batches ON students.batch_id = batches.id) \n"
            . "	INNER JOIN courses ON batches.course_id = courses.id)     \n"
            . "	INNER JOIN exam_groups ON students.batch_id = exam_groups.batch_id)\n"
            . "	INNER JOIN exams ON exam_groups.id = exams.exam_group_id)    \n"
            . "	INNER JOIN exam_scores\n"
            . "	ON students.id = exam_scores.student_id\n"
            . "       AND exam_scores.exam_id = exams.id)\n"
            . "	INNER JOIN subjects ON exams.subject_id = subjects.id) "
            . "WHERE  $terms $grades $batches $gender $subjects";
}

//        echo $sql;

$result = $conn->query($sql);
$rowcount = mysqli_num_rows($result);
echo $rowcount;

$conn->close();
