<?php
include_once('../connection.php');

header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['name']) && isset($data['password'])) {
    $name = $data['name'];
    $password = $data['password'];

    $sql = "SELECT * FROM `estudantes` WHERE `nome_estudante` = '" . $name . "' AND `senha` = '" . $password . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $usuario = mysqli_fetch_assoc($result);
        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION['nome_estudante'] = $usuario['nome_estudante'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['id'] = $usuario['id'];

        if ($usuario['id'] == 1) {
            http_response_code(200);
            echo json_encode(array("session" => true, "level" => 1, "message" => "Sessão iniciada com sucesso."));
        }else{
            http_response_code(200);
            echo json_encode(array("session" => true, "level" => 2, "message" => "Sessão iniciada com sucesso."));
        }
    } else {
        http_response_code(201);
        echo json_encode(array("session" => false, "level" => 0, "message" => "Usuário ou senha inválidos."));
    }
} else {
    http_response_code(404);
    echo json_encode(array("session" => false, "level" => 0, "message" => "Dados vazios."));
}

mysqli_close($conn);
?>