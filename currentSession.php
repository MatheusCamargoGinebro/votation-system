<?php
    if(!isset($_SESSION)){
        session_start();
    }

    echo "Valores da sessão: <br>";
    echo "Email: ".$_SESSION['email']." <br>";
    echo "Nome: ".$_SESSION['nome_estudante']." <br>";
    echo "ID: ".$_SESSION['id']." <br>";

    if(isset($_SESSION['email']) && isset($_SESSION['nome_estudante'])){
        echo "<br> Sessão iniciada.";
    }else{
        echo "<br> Sessão não iniciada.";
    }
?>
