<?php

namespace App\Repository\Abstract;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
abstract class RepositoryAbstract{
    public $connectionMySql = "mysql";
    public $connectionSqlite = "sqlite";

    /**
     * Function to set the connection for the tests
     */
    public function setTestConnection() : void{
        $this->connectionMySql= "sqlite";
        $this->connectionSqlite= "sqlite";
    }
}

?>
