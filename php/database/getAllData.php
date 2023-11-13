<?php
include_once("../connection.php");

$sql = "SELECT * FROM candidatos";
$result = mysqli_query($conn, $sql);
$candidatesSize = mysqli_num_rows($result);

if ($candidatesSize > 0) {
    $candidates = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $candidates[] = $row;
    }

    $sql = "SELECT `id`, `nome_estudante`, `email` FROM estudantes";
    $result = mysqli_query($conn, $sql);
    $studentsSize = mysqli_num_rows($result);

    if(mysqli_num_rows($result) > 0) {
        $students = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;
        }
        http_response_code(200);
        echo json_encode(array("candidatesSize" => $candidatesSize, "candidates" => $candidates, "StudentsSize" => $studentsSize, "students" => $students));
    } else {
        http_response_code(201);
        echo json_encode(array("candidatesSize" => $candidatesSize, "candidates" => $candidates, "StudentsSize" => 0, "students" => ""));
    }
} else {
    http_response_code(201);
    echo json_encode(array("candidatesSize" => 0, "candidates" => "", "StudentsSize" => 0, "students" => ""));
}
?>