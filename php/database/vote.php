<?php
include_once('../connection.php');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION)) {
    session_start();
}

if (isset($data['email']) && isset($data['candidateID'])) {
    if ($_SESSION['email'] == $data['email']) {
        // Use prepared statements to prevent SQL injection
        $sql = "SELECT * FROM `votantes` WHERE `email` = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $data['email']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 0) {
            mysqli_stmt_close($stmt);

            // Inserting a new voter
            $sql = "INSERT INTO `votantes` (`email`) VALUES (?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $data['email']);
            mysqli_stmt_execute($stmt);

            if ($stmt) {
                mysqli_stmt_close($stmt);

                // Updating candidate votes
                $sql = "UPDATE `candidatos` SET `votos` = `votos` + 1 WHERE `id` = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $data['candidateID']);
                mysqli_stmt_execute($stmt);

                if ($stmt) {
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
        } else {
            http_response_code(201);
            echo json_encode(array("session" => true, "success" => false, "message" => "Você já havia votado."));
        }
    } else {
        http_response_code(201);
        echo json_encode(array("session" => true, "success" => false, "message" => "Sessão inválida."));
    }
} else {
    http_response_code(201);
    echo json_encode(array("session" => true, "success" => false, "message" => "Dados vazios."));
}

mysqli_close($conn);
exit();
?>
