<?php
        $servername = "localhost";          $username = "reports2018";
        $password = "Indepth2018";        $DB = "fedena_pro";

        $conn = new mysqli($servername, $username, $password, $DB);

        if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error . "\n");
        }

$grades = $_REQUEST["grades"];
        $batches = $_REQUEST["batches"];
        $subjects = $_REQUEST["subjects"];
        $gender = $_REQUEST["gender"];
        $terms = $_REQUEST["terms"];
    
       $sql =       " SELECT students.admission_no, students.first_name, students.gender," .
                        " marks.Exam_Group, marks.Grade, marks.Batch, marks.Subject, marks.Mark " .
                        " FROM marks" .
                        " INNER JOIN students ON students.admission_no = marks.MOE" .
                        " WHERE $terms $grades $batches $gender $subjects";
       //echo $sql;
        
        
        

        
        $result = $conn->query($sql);
        $rowcount=mysqli_num_rows($result);
        echo $rowcount;
        
        $conn->close();
