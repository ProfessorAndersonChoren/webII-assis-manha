<?php

namespace QI\SistemaDeChamados\Controller;

use Exception;
use QI\SistemaDeChamados\Model\{Call, User, Equipment};
use QI\SistemaDeChamados\Model\Repository\CallRepository;

require_once dirname(dirname(__DIR__)) . "/vendor/autoload.php";

session_start();
switch ($_GET["operation"]) {
    case "insert":
        insert();
        break;
    case "findAll":
        findAll();
        break;
    case "findOne":
        findOne();
        break;
    case "delete":
        delete();
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
    $user->id = 1;
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


    try {
        $callRepository = new CallRepository();
        $result = $callRepository->insert($call);
        if ($result) {
            $_SESSION["msg_success"] = "Chamado registrado com sucesso!!!";
        } else {
            $_SESSION["msg_warning"] = "Não foi possível registrar o chamado!!!";
        }
    } catch (Exception $exception) {
        $_SESSION["msg_error"] = "Houve um erro em nossa base de dados!!!";
        Logger::writeLog($exception->getMessage());
    } finally {
        header("location:../View/message.php");
        exit;
    }
}

function findAll()
{
    try {
        $call_repository = new CallRepository();
        $_SESSION["list-of-calls"] = $call_repository->findAll();
        header("location:../View/list-of-calls.php");
        exit;
    } catch (Exception $exception) {
        $_SESSION["msg_error"] = "Ops, houve um erro em nossa base de dados";
        Logger::writeLog($exception->getMessage());
    } finally {
        header("location:../View/message.php");
        exit;
    }
}

function findOne()
{
    $id = $_GET["code"];
    if(empty($id)){
        $_SESSION["msg_error"] = "O código do chamado é inválido!!!";
        header("location:../View/message.php");
        exit;
    }
    $call_repository = new CallRepository();
    $call = $call_repository->findOne($id);
    if(!empty($call)){
        $_SESSION["call"] = $call;
        header("location:../View/call-edit.php");
    }else{
        $_SESSION["msg_warning"] = "O código $id não pertence a nenhum chamado em nossa base de dados";
        header("location:../View/message.php");
    }
}

function delete()
{
    $id = $_GET["code"];
    if (empty($id)) {
        $_SESSION["msg_error"] = "O código do chamado é inválido!!!";
        header("location:../View/message.php");
        exit;
    }
    try {
        $call_repository = new CallRepository();
        $result = $call_repository->delete($id);
        if ($result) {
            $_SESSION["msg_success"] = "Chamado removido com sucesso!!!";
        } else {
            $_SESSION["msg_warning"] = "Lamento, não foi possível remover o chamado!!!";
        }
    } catch (Exception $exception) {
        $_SESSION["msg_error"] =
            "Ops, houve um erro em nossa base de dados";
        Logger::writeLog($exception->getMessage());
    } finally {
        header("location:../View/message.php");
    }
}
