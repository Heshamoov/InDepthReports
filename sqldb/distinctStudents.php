<?php
        $servername = "localhost";          $username = "reports2018";
        $password = "Indepth2018";        $DB = "fedena_pro";

        $conn = new mysqli($servername, $username, $password, $DB);

        if ($conn->connect_error)
                die("Connection failed: " . $conn->connect_error . "\n");
    
        $grade = $_REQUEST["grade"];
        $batch = $_REQUEST["batch"];
        
        $sql = "SELECT moe FROM students where grade = '$grade' and batch = '$batch'";
        $result = $conn->query($sql);
//        echo $sql;

        while ($row = mysqli_fetch_array($result))
                echo $row["moe"] . " ";
        
        $conn->close();