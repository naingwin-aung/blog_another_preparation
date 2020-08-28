<?php
class DAL
{
     private $pdo;
     private static $instance;

     private function __construct()
     {
          try {
               $this->pdo = new PDO("mysql:dbname=blog;host=localhost",'root','root');
               $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $e) {
               $e->getMessage();
          }
     }
     public static function getInstance() 
     {
          if(!static::$instance) {
               static::$instance = new DAL();
          }
          return static::$instance;
     }

     public function getConn()
     {
          return $this->pdo;
     }
}
     