<?php

include ('/srv/InDepthReports/config/dbConfig.php');

$sql = "SELECT DISTINCT course_name FROM courses\n"
        . "WHERE is_deleted = 0\n"
        . "ORDER BY created_at";

$result = $conn->query($sql);

while ($row = mysqli_fetch_array($result))
    echo $row['course_name'] . "\n";

$conn->close();
