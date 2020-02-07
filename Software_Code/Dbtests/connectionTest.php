<?php

use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
    public $conn = null;
    static $pdo = null;

    final public function getConnection(){
        if ($this->conn === null){
            if (self::$pdo == null){
                self::$pdo = new PDO('mysql::dbname=19agileteam12db;host=silva.computing.dundee.ac.uk','19agileteam12','2437.at12.7342');
            }
            $this->conn = createDefaultDBConnection(self::$pdo, ':memory:');
        }
        return $this->conn;
    }

    public function testConnection(){
        $conn = $this->getConnection();
        $this->assertTrue($conn->rowExists());
    }
}
?>