<?php
        $servername = "localhost";          $username = "reports2018";
        $password = "Indepth2018";        $DB = "fedena_pro";

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
    
        $sql =           " SELECT *" .
                        " FROM gold" .
                        " WHERE $terms $grades $batches $gender $subjects" .
                        " AND (mark BETWEEN $min AND $max)";
   //   echo $sql;
        
        $result = $conn->query($sql);
        $rowcount=mysqli_num_rows($result);
        echo $rowcount;

        $conn->close();