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
        $min = $_REQUEST["min"];
        $max = $_REQUEST["max"];
    
        $sql =       " SELECT students.admission_no, students.first_name, students.gender," .
                        " marks.Exam_Group, marks.Grade, marks.Batch, marks.Subject, marks.Mark " .
                        " FROM marks" .
                        " INNER JOIN students ON students.admission_no = marks.MOE" .
                        " WHERE $terms $grades $batches $gender $subjects" .
                        " AND (mark BETWEEN $min AND $max)";
//      echo $sql;
        
        $result = $conn->query($sql);
        $rowcount=mysqli_num_rows($result);
        echo $rowcount;

        $conn->close();