<?php
        $servername = "localhost";          $username = "reports2018";
        $password = "Indepth2018";        $DB = "alsanawbar2018";

        $conn = new mysqli($servername, $username, $password, $DB);

        if ($conn->connect_error)
                die("Connection failed: " . $conn->connect_error . "\n");

        $grade = $_REQUEST["grade"];
        $sql = "SELECT DISTINCT batch FROM marks WHERE grade = '$grade'";
        $result = $conn->query($sql);
    
        while($row = mysqli_fetch_array($result))
                echo $row['batch'] . " ";
        
        $conn->close();