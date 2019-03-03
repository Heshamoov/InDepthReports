<?php

$servername = "localhost";
$username = "reports2018";
$password = "Indepth2018";
$DB = "alsanawbar2018";

$conn = new mysqli($servername, $username, $password, $DB);

if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error . "\n");

$sql = "UPDATE `students` SET " . $_REQUEST["sql"];
echo $sql;

if ($conn->query($sql) === TRUE)
    echo "\nStudnets updated successfully\n";
else
    echo "\nError updating: " . $conn->error . "\n";

$conn->close();
