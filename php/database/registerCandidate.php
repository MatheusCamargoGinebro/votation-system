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
        // verificando disponibilidade de nome e número:
        $sql = "SELECT * FROM `candidatos` WHERE `nome_candidato` = '" . $data['name'] . "'";
        $result = mysqli_query($conn, $sql);
        $nameStatus;

        if (mysqli_num_rows($result) == 0) {
            $nameStatus = true;
        } else {
            $nameStatus = false;
        }

        $sql = "SELECT * FROM `candidatos` WHERE `numero_candidato` = '" . $data['number'] . "'";
        $result = mysqli_query($conn, $sql);
        $numberStatus;

        if (mysqli_num_rows($result) == 0) {
            $numberStatus = true;
        } else {
            $numberStatus = false;
        }

        if ($numberStatus == false || $nameStatus == false) {
            http_response_code(201);
            echo json_encode(array("success" => false, "session" => true, "level" => 1, "message" => "Dados já cadastrados.", "name" => $nameStatus, "number" => $numberStatus));
        } else {
            // cadastrando candidato:
            $sql = "INSERT INTO `candidatos` (`nome_candidato`, `numero_candidato`) VALUES ('" . $data['name'] . "', '" . $data['number'] . "')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                http_response_code(200);
                echo json_encode(array("success" => true, "session" => true, "level" => 1, "message" => "Cadastro realizado com sucesso.", "name" => $nameStatus, "number" => $numberStatus));
            } else {
                http_response_code(201);
                echo json_encode(array("success" => false, "session" => false, "level" => 1, "message" => "Erro ao cadastrar.", "name" => $nameStatus, "number" => $numberStatus));
            }
        }
    } else {
        $nameStatus;
        if (isset($data['name'])) {
            $nameStatus = true;
        } else {
            $nameStatus = false;
        }

        $numberStatus;
        if (isset($data['number'])) {
            $numberStatus = true;
        } else {
            $numberStatus = false;
        }

        http_response_code(201);
        echo json_encode(array("success" => false, "session" => false, "level" => 1, "message" => "Dados inválidos.", "name" => $nameStatus, "number" => $numberStatus));
    }
}
exit();
?>