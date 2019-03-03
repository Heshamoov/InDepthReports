<?php

$servername = "localhost";
$username = "reports2018";
$password = "Indepth2018";
$DB = "alsanawbar2018";

$conn = new mysqli($servername, $username, $password, $DB);

if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error . "\n");

$sql = "CREATE TABLE students (
                                MOE INT(6) UNSIGNED PRIMARY KEY, 
                                Name VARCHAR(50) NOT NULL,
                                Grade VARCHAR(10) NOT NULL,
                                Batch VARCHAR(10) NOT NULL,
                                Nationality VARCHAR(50),
                                Gender CHAR(6),
                                Religion CHAR(10),
                                Phone CHAR(15),
                                Mobile CHAR(15),
                                `Admission Date` Date
                        )";

if ($conn->query($sql) === TRUE)
    echo "\nStudnets table created successfully\n";
else
    echo "\nError creating table: " . $conn->error . "\n";

$conn->close();
