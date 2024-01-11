<?php

class Categorie
{
    private $db;

    public function __construct()
    {
        $this->db=new Database;
    }
    public function  fetch_categories(){
        $this->db->query(" SELECT * FROM wiki.categories");
        $this->db->execute();
        return  $this->db->resultSet();
    }
    public function getRecentCategories($limit = 5)
    {
        $this->db->query('
            SELECT
                CategoryID,
                CategoryName
            FROM
                wiki.categories
            ORDER BY
                CreatedAt DESC
            LIMIT :limit
        ');

        $this->db->bind(':limit', $limit);

        return $this->db->resultSet();
    }
    public function addCategorie($data){
        $this->db->query('INSERT INTO wiki.categories (CategoryName,Created_AdminID) VALUES(:categorie_name ,:created_adminId )');
        //Bind valuev

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
    public function get_this_category($id_categ){
        $this->db->query(" SELECT * FROM wiki.categories WHERE CategoryID=:category_id");
        $this->db->bind(':category_id', $id_categ );

        return  $this->db->single();
    }
}