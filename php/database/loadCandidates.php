<?php
include_once("../connection.php");

$sql = "SELECT * FROM candidatos";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $candidates = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $candidates[] = $row;
    }
    http_response_code(200);
    echo json_encode(array("size" => mysqli_num_rows($result), "candidates" => $candidates));
} else {
    http_response_code(201);
    echo json_encode(array("size" => 0, "candidates" => ""));
}
?>