<?php

class Wiki
{
    private $db;

    public function __construct()
    {
        $this->db=new Database;
    }
    public function getWikis(){
        $this->db->query('SELECT * FROM wiki.wikis;');
        return $this->db->resultSet();
    }

}