<?php

class Tag
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function fetch_tags(){
        $this->db->query(" SELECT * FROM wiki.tags");
        $this->db->execute();
        return  $this->db->resultSet();
    }

    public function addTag($data)
    {
        $this->db->query('INSERT INTO wiki.tags (TagName, created_id) VALUES(:tag_name, :created_adminId)');
        // Bind values
        $this->db->bind(':tag_name', $data['tag_name']);
        $this->db->bind(':created_adminId', $data['user_id']);
        // Execute
        return $this->db->execute();
    }

    public function getTagId($id)
    {
        $this->db->query('SELECT * FROM wiki.tags WHERE TagID = :tagID');
        $this->db->bind(':tagID', $id);

        return $this->db->single();
    }

    public function updateTag($data)
    {
        $this->db->query('UPDATE wiki.tags SET TagName = :tag_name WHERE TagID = :tagID');
        // Bind values
        $this->db->bind(':tagID', $data['TagID']);
        $this->db->bind(':tag_name', $data['tag_name']);
        // Execute
        return $this->db->execute();
    }

    public function deleteTag($id)
    {
        $this->db->query('DELETE FROM wiki.tags WHERE TagID = :tagID');
        $this->db->bind(':tagID', $id);
        // Execute
        return $this->db->execute();
    }
    public function add_wiki_tags($id, $tags)
    {
        // Ensure $tags is an array before proceeding
        if (!is_array($tags)) {
            // Handle the situation where $tags is not an array (it might be null or something else)
            echo "Invalid tags data.";
            return false;
        }

        foreach ($tags as $tag) {
            // Assuming your table is named "tags" with columns "tag_id" and "name"
            $this->db->query("INSERT INTO wiki.wikitags (WikiID,TagID) VALUES (:wiki_id,:tag_id)");
            $this->db->bind(':wiki_id', $id);
            $this->db->bind(':tag_id', $tag);
            $this->db->execute();
        }

        echo "Records inserted successfully.";
    }
    public function get_tags_wiki($id){
        $this->db->query( "SELECT * FROM wiki.tags join wiki.wikitags on wikitags.TagID = tags.TagID WHERE wikitags.WikiID=:wiki_id ");
        $this->db->bind(':wiki_id',$id);

        return $this->db->resultSet();
    }
    public function delete_tags($id){
        try{
            $this->db->query('DELETE  FROM wiki.wikitags WHERE WikiID  = :wiki_id');
            $this->db->bind(':wiki_id',$id);
            if( $this->db->execute()){
                return true;
            }else{
                return false;
            }

        }catch(PDOException $e){
            echo $e->getMessage();
        }

    }
}

