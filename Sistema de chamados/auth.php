<?php
session_start();
if (empty($_POST)) {
    $_SESSION["msg_error"] = "Ops, houve um erro inesperado!!!";
    header("location:message.php");
    exit;
}

$email = $_POST["user_email"];
$password = $_POST["user_password"];

// Simulação do banco
$users = array(
    array(
        "name" => "João",
        "email"=> "joao@gmail.com",
        "password" => password_hash("123456", PASSWORD_DEFAULT)
    ),
    array(
        "name" => "Maria",
        "email" => "maria@gmail.com",
        "password" => password_hash("123456", PASSWORD_DEFAULT)
    ),
);