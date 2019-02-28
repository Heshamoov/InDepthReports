<?php
        $servername = "localhost";          $username = "reports2018";
        $password = "Indepth2018";        $DB = "fedena_pro";

        $conn = new mysqli($servername, $username, $password, $DB);

        if ($conn->connect_error)
                die("Connection failed: " . $conn->connect_error . "\n");

        $grade = $_REQUEST["grade"];
        $sql = "SELECT DISTINCT batches.name name FROM batches\n "
                . "INNER JOIN courses\n"
                . "ON batches.course_id = courses.id\n"
                . "WHERE courses.course_name = '$grade'"
                . "ORDER By batches.id DESC";
//                echo $sql;
        
        

        $result = $conn->query($sql);
        while($row = mysqli_fetch_array($result))
        { echo $row['name'] . "?";}
        
        $conn->close();