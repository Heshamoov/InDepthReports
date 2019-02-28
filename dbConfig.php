<?php

/* 
 * Author: Jamsheed
 * Email: jamsheedkhalid35@gmail.com
 */

 $servername = "localhost";          $username = "reports2018";
 $password = "Indepth2018";          $DB = "fedena_pro";

        $conn = new mysqli($servername, $username, $password, $DB);

        if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error . "\n");
        }
        
?>

