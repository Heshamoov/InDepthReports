<?php

include ('../dbConfig.php');



//   -----------arabic encoding----------------
$sSQL = 'SET CHARACTER SET utf8';
mysqli_query($conn, $sSQL)
        or die('Can\'t charset in DataBase');
//    -----------arabic encoding-------------

$terms = $_REQUEST["terms"];
$grades = $_REQUEST["grades"];
$batches = $_REQUEST["batches"];
$subjects = $_REQUEST["subjects"];
$gender = $_REQUEST["gender"];
//    echo $subjects;
//    $sql =  " SELECT moe, name, students.gender," .
//            " marks.exam_group, marks.grade, marks.batch, marks.subject, marks.mark " .
//            " FROM marks" .
//            " INNER JOIN students ON marks.moe = students.admission_no " .
//            " WHERE $terms $grades $batches $gender $subjects";

if ($terms == "" and $grades == "" and $batches == "" and $gender == "" and $subjects == "") {

    $sql = "SELECT DISTINCT students.admission_no moe, students.first_name name, students.gender gender, batches.name batch_name, \n"
            . "courses.course_name grade,exam_groups.name exam_name,\n"
            . " exam_scores.marks marks,subjects.name subject_name\n"
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
            . "ON subjects.id = exams.subject_id)\n ";
} else {
    $sql = "SELECT DISTINCT students.admission_no moe, students.first_name name, students.gender gender, batches.name batch_name, \n"
            . "courses.course_name grade,exam_groups.name exam_name,\n"
            . " exam_scores.marks marks,subjects.name subject_name\n"
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
$rownumber = 1;
if ($result->num_rows > 0) {
    echo "<thead><tr id =out class= w3-custom  ><th>No</th><th>MOE</th>" .
    "<th>Name</th><th>Gender</th><th>Exam Group</th>" .
    "<th>Grade</th><th>Section</th>" .
    "<th>Subject</th><th>Mark</th></tr></thead><tbody>";

    while ($row = $result->fetch_assoc())
        echo "<tr><td>" . $rownumber++ . "</td><td>" . $row["moe"] .
        "</td><td style = font-size:16px; font-style: oblique>" . $row["name"] . "</td><td>" . ($row["gender"] == 'm' ? 'M' : 'F') .
        "</td><td>" . $row["exam_name"] . "</td><td>" . $row["grade"] .
        "</td><td>" . $row["batch_name"] . "</td><td>" . $row["subject_name"] .
        "</td><td>" . $row["marks"] . "</td></tr>";
    echo "</tbody>";
} else
    echo "Data Not Found, try to import it to DB";

$conn->close();




