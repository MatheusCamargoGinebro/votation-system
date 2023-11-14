<?php
include_once("../connection.php");

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
    if ($_SESSION['id'] == 1) {
        http_response_code(200);
        echo json_encode(array("session" => true, "level" => 1, "voted" => true, "email" => $_SESSION['email']));
    } else {
        http_response_code(200);
        $sql = "SELECT * FROM `votantes` WHERE `email` = '" . $_SESSION['email'] . "'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            http_response_code(200);
            echo json_encode(array("session" => true, "level" => 2, "voted" => true, "email" => $_SESSION['email']));
        } else {
            http_response_code(200);
            echo json_encode(array("session" => true, "level" => 2, "voted" => false, "email" => $_SESSION['email']));
        }
    }
} else {
    http_response_code(201);
    echo json_encode(array("session" => false, "level" => 0, "voted" => false, "email" => ""));
}

mysqli_close($conn);
exit();
?>