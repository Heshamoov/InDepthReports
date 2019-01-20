<?php
        $servername = "localhost";          $username = "reports2018";
        $password = "Indepth2018";        $DB = "fedena_pro";

        $conn = new mysqli($servername, $username, $password, $DB);

        if ($conn->connect_error)
                die("Connection failed: " . $conn->connect_error . "\n");
        
        $sql = "SELECT code FROM courses WHERE is_deleted = 0";
        $result = $conn->query($sql);
        
        while($row = mysqli_fetch_array($result))
                echo $row['code'] . "\n";
        
        $conn->close();