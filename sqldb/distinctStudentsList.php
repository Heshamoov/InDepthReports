<?php

$servername = "localhost";
$username = "reports2018";
$password = "Indepth2018";
$DB = "alsanawbar2018";

$conn = new mysqli($servername, $username, $password, $DB);

if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error . "\n");

$sql = "SELECT moe FROM students";
$result = $conn->query($sql);
echo $sql;

while ($row = mysqli_fetch_array($result))
    echo $row["moe"] . " ";

$conn->close();
