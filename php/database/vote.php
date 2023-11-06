<?php
    include_once('../connection.php');

    header('Content-type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($_SESSION)) {
        session_start();
    }

    if(isset($data['email']) && isset($data['candidateID'])){
        if($_SESSION['email'] == $data['email']){
            $sql = "SELECT * FROM `votantes` WHERE `email` = '" . $data['email'] . "'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) == 0){
                $sql = "INSERT INTO `votantes` (`email`) VALUES ('" . $data['email'] . "')";
                mysqli_query($conn, $sql);

                if ($result) {
                    $sql = "UPDATE `candidatos` SET `votos` = `votos` + 1 WHERE `id` = " . $data['candidateID'] . ";";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        http_response_code(200);
                        echo json_encode(array("session" => true, "success" => true, "message" => "Voto computado com sucesso!"));
                    } else {
                        http_response_code(201);
                        echo json_encode(array("session" => true, "success" => false, "message" => "Erro ao computar voto."));
                    }
                } else {
                    http_response_code(201);
                    echo json_encode(array("session" => true, "success" => false, "message" => "Erro ao cadastrar email do votante."));
                }
            }else{
                http_response_code(201);
                echo json_encode(array("session" => true, "success" => false, "message" => "Você já havia votado."));
            }
        }else{
            http_response_code(201);
            echo json_encode(array("session" => true, "success" => false, "message" => "Sessão inválida."));
        }
    }else{
        http_response_code(201);
        echo json_encode(array("session" => true, "success" => false, "message" => "Dados vazios."));
    }
?>