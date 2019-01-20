<?php
        $servername = "localhost";          $username = "reports2018";
        $password = "Indepth2018";        $DB = "alsanawbar2018";

        $conn = new mysqli($servername, $username, $password, $DB);

        if ($conn->connect_error)
                die("Connection failed: " . $conn->connect_error . "\n");
    
        $q = "INSERT INTO students (moe, name, grade, batch) VALUES " . $_REQUEST["q"];
        echo $q;
        if ($conn->query($q) === TRUE)
                echo "Students information inserted successfully.\n";
        else
                echo "\nError: " . $conn->error . "\n";

        $countStudents = "SELECT moe FROM students";
        $result = $conn->query($countStudents);
        $rowcount=mysqli_num_rows($result);
        echo $rowcount . " Records inserted.\n";
        
        $conn->close();