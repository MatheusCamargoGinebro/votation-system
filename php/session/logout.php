<?php
if (isset($_SESSION)) {
    session_destroy();

    echo json_encode(array("success" => true, "message" => "Sessão finalizada."));
} else {
    echo json_encode(array("success" => false, "message" => "Não havia uma sessão aberta."));
}

exit();
?>