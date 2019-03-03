<?php

$servername = "localhost";
$username = "reports2018";
$password = "Indepth2018";
$DB = "alsanawbar2018";

$conn = new mysqli($servername, $username, $password, $DB);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n");
}

$grade = $_REQUEST["grade"];
$subject = $_REQUEST["subject"];

$sql = "SELECT Subject FROM marks WHERE Grade = '$grade' AND Subject = '$subject'";
//    echo $sql;

$result = $conn->query($sql);
$rowcount = mysqli_num_rows($result);
echo $rowcount;

$conn->close();
