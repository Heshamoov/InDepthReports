<?php

$servername = "localhost";
$username = "reports2018";
$password = "Indepth2018";
$DB = "alsanawbar2018";

$conn = new mysqli($servername, $username, $password, $DB);

if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error . "\n");

$sql = "SELECT DISTINCT grade, batch FROM marks";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result))
        echo $row['grade'] . " - " . $row['batch'] . "\n";
} else
    echo "Sorry, make sure that you've imported marks.\nError Message: " . $conn->error . ".\n";


$conn->close();
