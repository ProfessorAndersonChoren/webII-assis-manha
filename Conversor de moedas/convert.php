<?php
session_start();

if(!empty($_POST)){
    $money = $_POST["money"];
    $coin = $_POST["coin"];

    switch ($coin) {
        case "dollar":
            $_SESSION["amount_dollar"] = convertToDollar($money);
            header("location:message.php");
            break;
        case "euro":
            $_SESSION["amount_euro"] = convertToEuro($money);
            header("location:message.php");
            break;
    }
}else{
    $_SESSION["error"] = "Ops, houve um erro inesperado!!!";
    header("location:message.php");
}

function convertToDollar($money)
{
    return $money / 5;
}

function convertToEuro($money){
    return $money / 5.3;
}