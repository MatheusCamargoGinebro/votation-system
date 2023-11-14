<?php
include_once('../connection.php');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['name']) && isset($data['password'])) {
    $name = $data['name'];
    $password = $data['password'];

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM `estudantes` WHERE (`nome_estudante` = ? OR `email` = ?) AND `senha` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $name, $name, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

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
        } else {
            http_response_code(200);
            echo json_encode(array("session" => true, "level" => 2, "message" => "Sessão iniciada com sucesso."));
        }
    } else {
        http_response_code(201);
        echo json_encode(array("session" => false, "level" => 0, "message" => "Usuário ou senha inválidos."));
    }
    
    mysqli_stmt_close($stmt);
} else {
    http_response_code(201);
    echo json_encode(array("session" => false, "level" => 0, "message" => "Dados vazios."));
}

mysqli_close($conn);
exit();
?>
