<?php

include ('/srv/InDepthReports/config/dbConfig.php');



$grades = $_REQUEST["grades"];
$batches = $_REQUEST["batches"];
$subject = $_REQUEST["subject"];
$gender = $_REQUEST["gender"];
$terms = $_REQUEST["terms"];

if ($terms == "" and $grades == "" and $batches == "" and $gender == "") {
//        $sql =       " SELECT  subject FROM gold" .
//                     " WHERE subject LIKE '$subject%'";

 $sql = "SELECT students.admission_no moe, students.first_name name, students.gender gender, batches.name batch_name, courses.course_name grade,exam_groups.name exam_name, exam_scores.marks marks,subjects.name subject_name\n"
            . "\n"
            . "FROM ((((((\n"
            . "students\n"
            . "INNER JOIN batches ON students.batch_id = batches.id) \n"
            . "	\n"
            . "	INNER JOIN courses ON batches.course_id = courses.id)     \n"
            . "\n"
            . "	INNER JOIN exam_groups ON students.batch_id = exam_groups.batch_id)\n"
            . "\n"
            . "\n"
            . "	INNER JOIN exams ON exam_groups.id = exams.exam_group_id)    \n"
            . "	\n"
            . "	INNER JOIN exam_scores\n"
            . "	ON students.id = exam_scores.student_id\n"
            . "       AND exam_scores.exam_id = exams.id)\n"
            . "\n"
            . "	INNER JOIN subjects ON exams.subject_id = subjects.id)"
            . " WHERE subjects.name LIKE '$subject%'";
} else {
//        $sql =       " SELECT  subject FROM gold" .
//                     " WHERE $terms $grades $batches $gender  AND subjects.name LIKE '$subject%'";

 $sql = "SELECT students.admission_no moe, students.first_name name, students.gender gender, batches.name batch_name, courses.course_name grade,exam_groups.name exam_name, exam_scores.marks marks,subjects.name subject_name\n"
            . "\n"
            . "FROM ((((((\n"
            . "students\n"
            . "INNER JOIN batches ON students.batch_id = batches.id) \n"
            . "	\n"
            . "	INNER JOIN courses ON batches.course_id = courses.id)     \n"
            . "\n"
            . "	INNER JOIN exam_groups ON students.batch_id = exam_groups.batch_id)\n"
            . "\n"
            . "\n"
            . "	INNER JOIN exams ON exam_groups.id = exams.exam_group_id)    \n"
            . "	\n"
            . "	INNER JOIN exam_scores\n"
            . "	ON students.id = exam_scores.student_id\n"
            . "       AND exam_scores.exam_id = exams.id)\n"
            . "\n"
            . "	INNER JOIN subjects ON exams.subject_id = subjects.id)"
            . " WHERE $terms $grades $batches $gender  AND subjects.name LIKE '$subject%'";
}
//        echo $sql;

$result = $conn->query($sql);
$rowcount = mysqli_num_rows($result);
echo $rowcount;

$conn->close();
