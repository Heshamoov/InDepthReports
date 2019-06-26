<?php

include ('../config/dbConfig.php');


$terms = $_REQUEST["terms"];
$grades = $_REQUEST["grades"];
$batches = $_REQUEST["batches"];
$subjects = $_REQUEST["subjects"];
$gender = $_REQUEST["gender"];


if ($terms == "" and $grades == "" and $batches == "" and $gender == "" and $subjects == "") {

      $sql = "SELECT T2.s2_name s2_name, T1.Count Count, T2.Total Total, ((T1.Count * 100 )/ T2.Total)  AVG FROM " 
	     ."( SELECT count(*) Count, subjects.name s1_name "
	     ."FROM(((((( students INNER JOIN batches ON students.batch_id = batches.id) "
	     ."INNER JOIN courses ON batches.course_id = courses.id) "
	     ."INNER JOIN exam_groups ON students.batch_id = exam_groups.batch_id) "
	     ."INNER JOIN exams ON exam_groups.id = exams.exam_group_id) "
	     ."INNER JOIN exam_scores ON students.id = exam_scores.student_id AND exam_scores.exam_id = exams.id) "
	     ."INNER JOIN subjects ON exams.subject_id = subjects.id) "
	     ."WHERE exam_scores.marks > 75 GROUP BY subjects.name ) AS T1 JOIN "
	     ."( SELECT count(*) Total, subjects.name s2_name FROM "
	     ."(((((( students INNER JOIN batches ON students.batch_id = batches.id) "
	     ."INNER JOIN courses ON batches.course_id = courses.id) "
	     ."INNER JOIN exam_groups ON students.batch_id = exam_groups.batch_id) "
	     ."INNER JOIN exams ON exam_groups.id = exams.exam_group_id) "
	     ."INNER JOIN exam_scores ON students.id = exam_scores.student_id AND exam_scores.exam_id = exams.id) "
	     ."INNER JOIN subjects ON exams.subject_id = subjects.id) "
	     ."GROUP BY subjects.name) AS T2 ON T1.s1_name = T2.s2_name;";



			//echo $sql;
			$result = $conn->query($sql);
			$rownumber = 1;
			if ($result->num_rows > 0) {
			    echo "<thead><tr id =out class= w3-custom  ><th>Subjects</th>" 
			    ."<th>Total Students Attended</th>" 
			    ."<th>Students Scored Above Scale</th>"
			    ."<th>Average</th>"
			    ."<th>Attainment Status</th></tr></thead><tbody>";
			
			    while ($row = $result->fetch_assoc())
			        echo "<tr><td>" . $row["s2_name"] . "</td>"
			        	."<td>" . $row["Total"] . "</td>"
					."<td>" . $row["Count"] . "</td>"
			        	."<td>" . $row["AVG"] . "</td>"
					."<td>" . $row["subject_name"] . "</td></tr>";
			    echo "</tbody>";
			} else
    				echo "Data Not Found, try to import it to DB";



} else {
    $sql = "SELECT students.admission_no moe, students.first_name name, students.gender gender, batches.name batch_name, courses.course_name grade,exam_groups.name exam_name, exam_scores.marks marks,subjects.name subject_name\n"
            . "FROM ((((((\n"
            . "students\n"
            . "INNER JOIN batches ON students.batch_id = batches.id) \n"
            . "	INNER JOIN courses ON batches.course_id = courses.id)     \n"
            . "	INNER JOIN exam_groups ON students.batch_id = exam_groups.batch_id)\n"
            . "	INNER JOIN exams ON exam_groups.id = exams.exam_group_id)    \n"
            . "	\n"
            . "	INNER JOIN exam_scores\n"
            . "	ON students.id = exam_scores.student_id\n"
            . "       AND exam_scores.exam_id = exams.id)\n"
            . "	INNER JOIN subjects ON exams.subject_id = subjects.id) WHERE  $terms $grades $batches $gender $subjects"
            . " ORDER BY students.id ASC, exam_groups.name ";





//echo $sql;
$result = $conn->query($sql);
$rownumber = 1;
if ($result->num_rows > 0) {
    echo "<thead><tr id =out class= w3-custom  ><th>SI No.</th><th>Curriculum</th>" .
    "<th>Exam Group</th>" .
    "<th>Grade</th><th>Section</th>" .
    "<th>Subject</th><th>Attainment</th></tr></thead><tbody>";

    while ($row = $result->fetch_assoc())
        echo "<tr><td>" . $rownumber++ . "</td><td>" . $row["moe"] .
        "</td><td>" . $row["exam_name"] . "</td><td>" . $row["grade"] .
        "</td><td>" . $row["batch_name"] . "</td><td>" . $row["subject_name"] .
        "</td><td>" . $row["marks"] . "</td></tr>";
    echo "</tbody>";
} else
    echo "Data Not Found, try to import it to DB";

}

$conn->close();




