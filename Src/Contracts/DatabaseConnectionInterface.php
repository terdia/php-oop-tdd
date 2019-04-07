<?php


namespace App\Contracts;


interface DatabaseConnectionInterface
{

    public function connect();
    public function getConnection();
}