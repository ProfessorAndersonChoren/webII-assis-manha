<?php

namespace QI\SistemaDeChamados\Model\Repository;

use QI\SistemaDeChamados\Model\Call;
use \PDO;

class CallRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::getConnection();
    }

    /**
     * Insert a new call in database
     * @param Call $call
     * @return bool
     */
    public function insert($call)
    {
        $stmt = $this->connection->prepare("insert into calls values (null,?,?,?,?,?);");
        $stmt->bindParam(1, $call->user->id, PDO::PARAM_INT);
        $stmt->bindParam(2, $call->equipment->pc_number);
        $stmt->bindParam(3, $call->classification, PDO::PARAM_INT);
        $stmt->bindParam(4, $call->description);
        $stmt->bindParam(5, $call->notes);
        return $stmt->execute();
    }

    public function findAll(){
        $stmt = $this->connection->query("select c.*,u.name from calls c inner join users u on u.id = c.user_id order by classification desc;");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
