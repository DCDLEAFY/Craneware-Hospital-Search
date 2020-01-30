<?php
require_once './connection.php';

use PHPUnit\Framework\TestCase;

class test extends TestCase
{
    protected $object;

    static private $pdo = null;
    private $conn = null;

    public function getConnection(){
        if($this->conn == null){
            if(self::$pdo ==null){
                self::$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
            }
            $this->conn = $this->createDefaultFunction(self::$pdo, $GLOBALS['DB_NAME']);
        }
        return $this-conn;
    }

    protected function setUp():void
    {
        
    }
    
    protected function tearDown():void
    {
        
    }
    
    public function testNothing(){
        $this->assertTrue(true,'true');
    }
}