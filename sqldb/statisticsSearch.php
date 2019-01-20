<?php
    $servername = "localhost";          $username = "reports2018";
    $password = "Indepth2018";        $DB = "alsanawbar2018";

    $conn = new mysqli($servername, $username, $password, $DB);

    if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error . "\n");

    $terms = $_REQUEST["terms"];
    $grades = $_REQUEST["grades"];
    $batches = $_REQUEST["batches"];
    $subjects = $_REQUEST["subjects"];
    $gender = $_REQUEST["gender"];

    $sql =  " SELECT students.admission_no, students.first_name, students.gender," .
            " marks.exam_group, marks.grade, marks.batch, marks.subject, marks.mark " .
            " FROM marks" .
            " INNER JOIN students ON marks.moe = students.admission_no " .
            " WHERE $terms $grades $batches $gender $subjects";
//      echo $sql;
        $result = $conn->query($sql);
        $rownumber = 1;
        if ($result->num_rows > 0) {
                echo "<thead><tr class= w3-blue ><th>No</th><th>MOE</th>" .
                        "<th>Name</th><th>Gender</th><th>Exam Group</th>" .
                        "<th>Grade</th><th>Section</th>" .
                        "<th>Subject</th><th>Mark</th></tr></thead><tbody>";
                
                while($row = $result->fetch_assoc())
                        echo "<tr><td>"  . $rownumber++ . "</td><td>" . $row["admission_no"] . 
                                "</td><td>" . $row["first_name"] . "</td><td>" . $row["gender"] .
                                "</td><td>" . $row["exam_group"] . "</td><td>" . $row["grade"] .
                                "</td><td>" . $row["batch"] . "</td><td>" . $row["subject"] .
                                "</td><td>" . $row["mark"]."</td></tr>";
                echo "</tbody>";
        } else
                echo "Data Not Found, try to import it to DB";
        
        $conn->close();