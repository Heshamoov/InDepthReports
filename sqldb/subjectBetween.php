<?php

include ('../dbConfig.php');


$terms = $_REQUEST["terms"];
$grades = $_REQUEST["grades"];
$batches = $_REQUEST["batches"];
$subject = $_REQUEST["subject"];
$gender = $_REQUEST["gender"];
$min = $_REQUEST["min"];
$max = $_REQUEST["max"];

if ($terms == "" and $grades == "" and $batches == "" and $gender == "") {
//                $sql =       " SELECT *" .
//                                " FROM gold" .
//                                " WHERE subject LIKE '$subject%'" .
//                                " AND (mark BETWEEN $min AND $max)";
    $sql = "SELECT students.admission_no moe, students.first_name name, students.gender gender, batches.name batch_name, courses.course_name grade,exam_groups.name exam_name, exam_scores.marks marks,subjects.name subject_name\n"
            . "FROM ((((((\n"
            . "students\n"
            . "INNER JOIN batches ON students.batch_id = batches.id) \n"
            . "	INNER JOIN courses ON batches.course_id = courses.id)     \n"
            . "	INNER JOIN exam_groups ON students.batch_id = exam_groups.batch_id)\n"
            . "	INNER JOIN exams ON exam_groups.id = exams.exam_group_id)    \n"
            . "	INNER JOIN exam_scores\n"
            . "	ON students.id = exam_scores.student_id\n"
            . " AND exam_scores.exam_id = exams.id)\n"
            . "	INNER JOIN subjects ON exams.subject_id = subjects.id) "
            . " AND (exam_scores.marks BETWEEN $min AND $max)";
} else {
//              $sql =       " SELECT *" .
//                                " FROM gold" .
//                                " WHERE $terms $grades $batches $gender AND subject LIKE '$subject%'" .
//                                " AND (mark BETWEEN $min AND $max)";

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
            . " AND exam_scores.exam_id = exams.id)\n"
            . "	INNER JOIN subjects ON exams.subject_id = subjects.id) "
            . " WHERE $terms $grades $batches $gender AND subjects.name LIKE '$subject%'"
            . " AND (exam_scores.marks BETWEEN $min AND $max)";
}
//       echo $sql;

$result = $conn->query($sql);
$rowcount = mysqli_num_rows($result);
echo $rowcount;

$conn->close();
