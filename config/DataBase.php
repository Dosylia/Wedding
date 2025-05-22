<?php

// Launch database
namespace config;

class DataBase
{
    private const SERVER = "db5017791541.hosting-data.io";
    private const DB = "dbs14198705";
    private const USER = "dbu553736";
    private const MDP = "gRipxBtwSjlpAJ94T";
    private const PORT = "3306";
    
    private \PDO $bdd; 
    
    public function getBdd(): ? \PDO
    {
        try
        {
            $this -> bdd = new \PDO('mysql:host='.self::SERVER.';dbname='.self::DB.';charset=utf8mb4', self::USER, self::MDP, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        }
        catch(\Exception $message)
        {
            die('Error message is : '.$message -> getMessage());
        }
 
        return $this -> bdd;
    }
}

// Test database
// $bdd = new DataBase();
// var_dump($bdd -> getBdd());




