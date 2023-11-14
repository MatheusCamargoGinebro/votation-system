<?php
include_once('../connection.php');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    http_response_code(201);
    echo json_encode(array("success" => false, "session" => false, "level" => 0, "message" => "Você não está logado.", "name" => false, "number" => false));
} else if ($_SESSION['id'] != 1) {
    http_response_code(201);
    echo json_encode(array("success" => false, "session" => false, "level" => 0, "message" => "Registro não autorizado.", "name" => false, "number" => false));
} else {
    if (isset($data['name']) && isset($data['number'])) {
        // Checking availability of name and number using prepared statements
        $sql = "SELECT * FROM `candidatos` WHERE `nome_candidato` = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $data['name']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $nameStatus = (mysqli_num_rows($result) == 0);

        $sql = "SELECT * FROM `candidatos` WHERE `numero_candidato` = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $data['number']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $numberStatus = (mysqli_num_rows($result) == 0);

        mysqli_stmt_close($stmt);

        if (!$nameStatus || !$numberStatus) {
            http_response_code(201);
            echo json_encode(array("success" => false, "session" => true, "level" => 1, "message" => "Dados já cadastrados.", "name" => $nameStatus, "number" => $numberStatus));
        } else {
            // Registering candidate using prepared statements
            $sql = "INSERT INTO `candidatos` (`nome_candidato`, `numero_candidato`) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $data['name'], $data['number']);
            mysqli_stmt_execute($stmt);

            if ($stmt) {
                mysqli_stmt_close($stmt);

                http_response_code(200);
                echo json_encode(array("success" => true, "session" => true, "level" => 1, "message" => "Cadastro realizado com sucesso.", "name" => $nameStatus, "number" => $numberStatus));
            } else {
                http_response_code(201);
                echo json_encode(array("success" => false, "session" => false, "level" => 1, "message" => "Erro ao cadastrar.", "name" => $nameStatus, "number" => $numberStatus));
            }
        }
    } else {
        $nameStatus = isset($data['name']);
        $numberStatus = isset($data['number']);

        http_response_code(201);
        echo json_encode(array("success" => false, "session" => false, "level" => 1, "message" => "Dados inválidos.", "name" => $nameStatus, "number" => $numberStatus));
    }
}

mysqli_close($conn);
exit();
?>
