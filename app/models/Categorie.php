<?php

class Categorie
{
    private $db;

    public function __construct()
    {
        $this->db=new Database;
    }
    public function getCategories(){
        $this->db->query('SELECT * FROM wiki.categories;');
        return $this->db->resultSet();
    }
    public function addCategorie($data){
        $this->db->query('INSERT INTO wiki.categories (CategoryName,Created_AdminID) VALUES(:categorie_name ,:created_adminId )');
        //Bind value
        $this->db->bind(':categorie_name',$data['categorie_name']);
        $this->db->bind(':created_adminId',$data['user_id']);


        //Execute
        return $this->db->execute();
    }


    public function getCategorieId($id){
        $this->db->query('SELECT * FROM wiki.categories WHERE CategoryID = :categoryID');
        $this->db->bind(':categoryID',$id);

        return $this->db->single();
    }

    public function updateCategorie($data){
        $this->db->query('UPDATE  wiki.categories SET CategoryName = :category_name  WHERE CategoryID = :categoryID');
        //Bind value
        $this->db->bind(':categoryID',$data['CategoryID']);
        $this->db->bind(':category_name',$data['categorie_name']);


        //Execute
        return $this->db->execute();
    }
    public function deleteCategory($id){
        $this->db->query('DELETE FROM wiki.categories WHERE CategoryID = :categoryID');
        $this->db->bind(':categoryID',$id);
        //Execute
        return $this->db->execute();
    }

}