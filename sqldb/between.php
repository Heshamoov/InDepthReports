<?php

include ('../config/dbConfig.php');

$terms = $_REQUEST["terms"];
$grades = $_REQUEST["grades"];
$years = $_REQUEST["years"];
$batches = $_REQUEST["batches"];
$subjects = $_REQUEST["subjects"];
$gender = $_REQUEST["gender"];
$category = $_REQUEST["category"];
$min = $_REQUEST["min"];
$max = $_REQUEST["max"];

//        $sql =           " SELECT *" .
//                        " FROM gold" .
//                        " WHERE $terms $grades $batches $gender $subjects" .
//                        " AND (mark BETWEEN $min AND $max)";
//   echo $sql;
if ($terms == "" and $grades == "" and $batches == "" and $years == "" and $gender == "" and $subjects == "" and $category == "") {

   $sql = "SELECT students.admission_no moe, students.first_name name, students.gender gender, batches.name batch_name, courses.course_name grade,exam_groups.name exam_name, exam_scores.marks marks,subjects.name subject_name\n"
            . "\n"
            . "FROM ((((((((\n"
            . "students\n"
            . "LEFT JOIN student_categories on students.student_category_id) \n "
            . "INNER JOIN batches ON students.batch_id = batches.id) \n"
            . "	INNER JOIN courses ON batches.course_id = courses.id)     \n"
            . "	LEFT JOIN academic_years ON batches.academic_year_id = academic_years.id)     \n"
            . "	INNER JOIN exam_groups ON students.batch_id = exam_groups.batch_id)\n"
            . "	INNER JOIN exams ON exam_groups.id = exams.exam_group_id)    \n"
            . "	INNER JOIN exam_scores\n"
            . "	ON students.id = exam_scores.student_id\n"
            . "       AND exam_scores.exam_id = exams.id)\n"
            . "	INNER JOIN subjects ON exams.subject_id = subjects.id) "
            . " WHERE (exam_scores.marks BETWEEN $min AND $max)";
} else {

   $sql = "SELECT students.admission_no moe, students.first_name name, students.gender gender, batches.name batch_name, courses.course_name grade,exam_groups.name exam_name, exam_scores.marks marks,subjects.name subject_name\n"
            . "\n"
            . "FROM ((((((((\n"
            . "students\n"
            . "LEFT JOIN student_categories on students.student_category_id) \n "
            . "INNER JOIN batches ON students.batch_id = batches.id) \n"
            . "	LEFT JOIN academic_years ON batches.academic_year_id = academic_years.id)     \n"
            . "	INNER JOIN courses ON batches.course_id = courses.id)     \n"
            . "	INNER JOIN exam_groups ON students.batch_id = exam_groups.batch_id)\n"
            . "	INNER JOIN exams ON exam_groups.id = exams.exam_group_id)    \n"
            . "	INNER JOIN exam_scores\n"
            . "	ON students.id = exam_scores.student_id\n"
            . "       AND exam_scores.exam_id = exams.id)\n"
            . "	INNER JOIN subjects ON exams.subject_id = subjects.id)"
            . "WHERE  $terms $grades $years $batches $gender $category $subjects AND (exam_scores.marks BETWEEN $min AND $max) ";
}
//        echo $sql;
$result = $conn->query($sql);
$rowcount = mysqli_num_rows($result);
echo $rowcount;

$conn->close();
