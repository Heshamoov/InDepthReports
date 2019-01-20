<?php
        $servername = "localhost";          $username = "reports2018";
        $password = "Indepth2018";        $DB = "fedena_pro";

        $conn = new mysqli($servername, $username, $password, $DB);

        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error . "\n");
   
        $sql = "SELECT DISTINCT name FROM exam_groups ORDER BY name";
        $result = $conn->query($sql);

        while($row = mysqli_fetch_array($result))
                echo $row["name"] . "\n";
    
        $conn->close();
    