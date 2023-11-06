<?php
include_once('../connection.php');

header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['name']) && isset($data['email']) && isset($data['password'])){
    $sql = "SELECT * FROM `estudantes` WHERE `email` = '" . $data['email'] . "'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 0){
        $emailStatus = true;
    }else{
        $emailStatus = false;
    }

    $sql = "SELECT * FROM `estudantes` WHERE `nome_estudante` = '" . $data['name'] . "'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 0){
        $nameStatus = true;
    }else{
        $nameStatus = false;
    }

    if($emailStatus == false || $nameStatus == false){
        $sessionStatus = false;
        http_response_code(201);
    } else{
        $sql = "INSERT INTO `estudantes` (`nome_estudante`, `email`, `senha`) VALUES ('" . $data['name'] . "', '" . $data['email'] . "', '" . $data['password'] . "')";
        $result = mysqli_query($conn, $sql);

        if($result){
            $sql = "SELECT * FROM `estudantes` WHERE `nome_estudante` = '" . $data['name'] . "' AND `senha` = '" . $data['password'] . "'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) == 1){
                $usuario = mysqli_fetch_assoc($result);
                if(!isset($_SESSION)){
                    session_start();
                }

                $_SESSION['nome_estudante'] = $usuario['nome_estudante'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['id'] = $usuario['id'];

                $sessionStatus = true;
                $message = "Cadastro realizado com sucesso.";
                http_response_code(200);
            }else{
                $sessionStatus = false;
                $message = "Erro ao iniciar a sessão.";
                http_response_code(201);
            }
        }else{
            $sessionStatus = false;
            $message = "Erro ao realizar cadastro.";
            http_response_code(201);
        }
    }
    echo json_encode(array("session" => $sessionStatus, "level" => 2, "message" => $message, "email" => $emailStatus, "name" => $nameStatus));
}else{
    http_response_code(201);
    echo json_encode(array("session" => false, "level" => 0, "message" => "Dados vazios.", "email" => "", "name" => ""));
}
?>