<?php

$servername = "localhost";
$username = "reports2018";
$password = "Indepth2018";
$DB = "alsanawbar2018";

$conn = new mysqli($servername, $username, $password, $DB);

if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error . "\n");

$sql = "SELECT MAX(SMS), FamilyId, Name FROM parent GROUP BY FamilyId ORDER BY FamilyId";

$result = $conn->query($sql);
$number = 1;
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        echo $row['FamilyId'];
        echo "Dear Parent - Please find your account details for the school portal." .
        " User: " . $row['FamilyId'] .
        " Password: " . $row['FamilyId'] . "123 " .
        "URL: alsanawbar.school";
        $temp = $row['Name'];
        $parent = explode(' ', $temp);
        for ($i = 1; $i < count($parent); $i++)
            echo $parent[$i] . ' ';
        echo "<br>";
    }
} else
    echo "Sorry, make sure that you've imported marks.\nError Message: " . $conn->error . ".\n";


$conn->close();
