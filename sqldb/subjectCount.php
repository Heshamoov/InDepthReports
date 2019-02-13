<?php
        $servername = "localhost";          $username = "reports2018";
        $password = "Indepth2018";        $DB = "fedena_pro";

        $conn = new mysqli($servername, $username, $password, $DB);

        if ($conn->connect_error)
                die("Connection failed: " . $conn->connect_error . "\n");
    
        $grades = $_REQUEST["grades"];
        $batches = $_REQUEST["batches"];
        $subject = $_REQUEST["subject"];
        $gender = $_REQUEST["gender"];
        $terms = $_REQUEST["terms"];
        
        if ($terms == "" and $grades == "" and $batches == "" and $gender == "") {
        $sql =       " SELECT  subject FROM gold" .
                     " WHERE subject LIKE '$subject%'";
        } else {
        $sql =       " SELECT  subject FROM gold" .
                     " WHERE $terms $grades $batches $gender  AND subject LIKE '$subject%'";
            
        }
        //echo $sql;
        
        $result = $conn->query($sql);
        $rowcount=mysqli_num_rows($result);
        echo $rowcount;
        
        $conn->close();
