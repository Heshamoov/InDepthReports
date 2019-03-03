<?php

$servername = "localhost";
$username = "reports2018";
$password = "Indepth2018";
$DB = "alsanawbar2018";

$conn = new mysqli($servername, $username, $password, $DB);

if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error . "\n");

$sql = "CREATE TABLE marks (
                        Serial SMALLINT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        MOE INT(6) UNSIGNED NOT NULL, 
                        Exam_Group VARCHAR(30) NOT NULL,
                        Grade VARCHAR(10) NOT NULL,
                        Batch VARCHAR(10) NOT NULL,
                        Subject VARCHAR(30) NOT NULL,
                        Mark DECIMAL (5,2) UNSIGNED NOT NULL)";

if ($conn->query($sql) === TRUE)
    echo "Marks table created successfully\n";
else
    echo "Error creating table: " . $conn->error . "\n";

$conn->close();
