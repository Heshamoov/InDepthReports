<?php
        $servername = "localhost";          $username = "reports2018";
        $password = "Indepth2018";        $DB = "alsanawbar2018";

        $conn = new mysqli($servername, $username, $password, $DB);

        if ($conn->connect_error)
                die("Connection failed: " . $conn->connect_error . "\n");

        
        $term = $_REQUEST["term"];
        $grade = $_REQUEST["grade"];
        $subject = $_REQUEST["subject"];
        $gender = $_REQUEST["gender"];
        $min = $_REQUEST["min"];
        
        if ($gender === 'Both')
                $gender = "";
        else if ($gender === 'Boys') 
                $gender = " AND (students.Gender = 'm') ";
        else if ($gender === 'Girls')
                $gender = " AND (students.Gender = 'f') ";
            
        
        $sql = "SELECT students.Gender, marks.Mark FROM marks\n"

    . "INNER JOIN students ON students.admission_no = marks.MOE\n"

    . "WHERE (marks.Exam_Group = '$term') AND (marks.Grade = '$grade')"
                . " AND (marks.Subject = '$subject') AND (marks.mark >= $min) $gender";

//    echo $sql;
        
        $result = $conn->query($sql);
        $rowcount=mysqli_num_rows($result);
        echo $rowcount;

        $conn->close();