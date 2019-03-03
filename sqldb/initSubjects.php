<?php

$servername = "localhost";
$username = "reports2018";
$password = "Indepth2018";
$DB = "fedena_pro";

$conn = new mysqli($servername, $username, $password, $DB);

if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error . "\n");
//   -----------arabic encoding----------------
$sSQL = 'SET CHARACTER SET utf8';
mysqli_query($conn, $sSQL)
        or die('Can\'t charset in DataBase');
//    -----------arabic encoding-------------


$sql = "SELECT DISTINCT name FROM subjects WHERE is_deleted = 0";
$result = $conn->query($sql);


while ($row = mysqli_fetch_array($result))
    echo $row['name'] . "\n";

$conn->close();
