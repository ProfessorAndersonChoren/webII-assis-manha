<?php

namespace QI\SistemaDeChamados\Controller;

use QI\SistemaDeChamados\Model\Call;
use QI\SistemaDeChamados\Model\Equipment;
use QI\SistemaDeChamados\Model\User;
use QI\SistemaDeChamados\Model\Repository\Connection;

require_once dirname(dirname(__DIR__)) . "/vendor/autoload.php";

session_start();
switch ($_GET["operation"]) {
    case "insert":
        insert();
        break;
    default:
        $_SESSION["msg_warning"] = "Operação inválida!!!";
        header("location:../View/message.php");
        exit;
}

function insert()
{
    if (empty($_POST)) {
        $_SESSION["msg_warning"] = "Ops, houve um erro inesperado!!!";
        header("location:../View/message.php");
        exit;
    }

    $user = new User($_POST["user_email"]);
    $user->name = $_POST["user_name"];
    $equipment = new Equipment(
        $_POST["pc_number"],
        intval($_POST["floor"]),
        intval($_POST["room"]),
    );
    $call = new Call($user, $equipment, $_POST["classification"], $_POST["description"]);

    if (!empty($_POST["notes"])) {
        $call->notes = $_POST["notes"];
    }

    // TODO Validar os dados vindos do formulário

    // TODO Criar o objeto CallRepository
}
