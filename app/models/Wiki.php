<?php

class Wiki
{
    private $db;

    public function __construct()
    {
        $this->db=new Database;
    }
    public function get_wikis() {
        $this->db->query('
        SELECT
            w.WikiID,
            w.Title,
            w.Content,
            w.AuthorID,
        
            c.CategoryID,
            c.CategoryName,
            
            GROUP_CONCAT(t.TagName SEPARATOR " , ") AS TagNames
        FROM
            wiki.wikis w
        JOIN wiki.categories c ON w.CategoryID = c.CategoryID
        LEFT JOIN wiki.wikitags wt ON w.WikiID = wt.WikiID
        LEFT JOIN wiki.tags t ON wt.TagID = t.TagID
       
            w.archive = 1 and 
        GROUP BY
            w.WikiID
        ORDER BY
            w.CreationDate DESC
    ');

        return $this->db->resultSet();
    }

    public function add_wiki($data){
        $this->db->query('INSERT INTO wiki.wikis (title, content ,CreationDate ,AuthorID,CategoryID,archive) 
         VALUES (:title,:content,CURRENT_DATE,:autheur,:CategoryID,1)');
        $this->db->bind(':title', $data['titre']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':autheur', $_SESSION['user_id']);
        $this->db->bind(':CategoryID',$data['CategoryID']);



        if ($this->db->execute()) {
            // Get the last inserted ID
            $lastInsertId = $this->db->lastInsertId();
            return $lastInsertId;
        } else {
            return false;
        }
    }
    public function getWikiById($id)
    {
        try{
            $this->db->query(' SELECT
            w.WikiID,
            w.Title,
            w.Content,
            w.AuthorID,
            c.CategoryID,
            c.CategoryName,
            u.FirstName,
            u.LastName,
            GROUP_CONCAT(t.TagName SEPARATOR " , ") AS TagNames
        FROM
            wiki.wikis w
        JOIN wiki.categories c ON w.CategoryID = c.CategoryID
        LEFT JOIN wiki.wikitags wt ON w.WikiID = wt.WikiID
        LEFT JOIN wiki.tags t ON wt.TagID = t.TagID
        LEFT JOIN wiki.users u ON w.AuthorID = u.ID_User
        WHERE
            w.archive = 1 AND w.WikiID=:wikiID
        GROUP BY
            w.WikiID
        ORDER BY
            w.CreationDate DESC ');

            $this->db->bind(':wikiID', $id);
            $this->db->execute();
            return $this->db->resultSet();
        }catch(PDOException $e){
            return $e->getMessage();

        }
    }

    public function found_wiki($input){

        try{
            $this->db->query("SELECT
            wiki.categories.CategoryName,
            GROUP_CONCAT(wiki.tags.TagName SEPARATOR ', ') AS TagNames ,
            wikis.*
        FROM
            wikis
        LEFT JOIN
            wiki.categories ON wikis.CategoryID = wiki.categories.CategoryID
        LEFT JOIN
            wiki.wikitags ON wikis.WikiID = wiki.wikitags.WikiID
        LEFT JOIN
            wiki.tags ON wiki.wikitags.TagID = wiki.tags.TagID
        WHERE (wikis.Title LIKE '%{$input}%' OR categories.CategoryName LIKE '%{$input}%' OR tags.TagName LIKE '%{$input}%' ) and wikis.archive = 1
        GROUP BY
            wikis.WikiID
        ORDER BY
            wikis.CreationDate DESC;
        ");
            $this->db->execute();
            return $this->db->resultSet();
        }catch(PDOException $e){
            return $e->getMessage();

        }

    }

    public function getRecentPosts($limit = 5)
    {
        $this->db->query('
            SELECT
                WikiID,
                Title,
                archive
            FROM
                wiki.wikis
            ORDER BY
                CreationDate DESC
            LIMIT :limit
        ');

        $this->db->bind(':limit', $limit);

        return $this->db->resultSet();
    }
    public function getTotalWikis() {
        $this->db->query('SELECT COUNT(*) as totalWikis FROM wiki.wikis');
        return $this->db->single()->totalWikis;
    }

    public function getMostProlificAuthor() {
        $this->db->query('
            SELECT u.Firstname, COUNT(w.AuthorID) as wikiCount
            FROM wiki.wikis w
            JOIN wiki.users u ON w.AuthorID = u.ID_User
            GROUP BY w.AuthorID
            ORDER BY wikiCount DESC
            LIMIT 1
        ');

        return $this->db->single();
    }

    public function getTotalTags() {
        $this->db->query('SELECT COUNT(*) as totalTags FROM wiki.tags');
        return $this->db->single()->totalTags;
    }

    public function getTotalAuthors() {
        $this->db->query('SELECT COUNT( ID_User) as totalAuthors FROM wiki.users');
        return $this->db->single()->totalAuthors;
    }

    public function getTotalCategories() {
        $this->db->query('SELECT COUNT(*) as totalCategories FROM wiki.categories');
        return $this->db->single()->totalCategories;
    }

    public function getMostUsedCategory() {
        $this->db->query('
            SELECT c.CategoryName, COUNT(w.CategoryID) as categoryCount
            FROM wiki.wikis w
            JOIN wiki.categories c ON w.CategoryID = c.CategoryID
            GROUP BY w.CategoryID
            ORDER BY categoryCount DESC
            LIMIT 1
        ');
        return $this->db->single();
    }
    public function get_this_wikis($id){

        $this->db->query(" SELECT * FROM wiki.wikis WHERE WikiID=:wiki_id");
        $this->db->bind(':wiki_id', $id );
        $this->db->execute();
        return  $this->db->single();

    }
    public function update_wiki($id,$data){
        try {

            $this->db->query('UPDATE wiki.wikis SET  Title = :title, Content = :content, CategoryID = :category_id WHERE WikiID = :wiki_id');
            $this->db->bind(':title', $data['titre']);
            $this->db->bind(':content', $data['content']);
            $this->db->bind(':category_id', $data['CategoryID']);
            $this->db->bind(':wiki_id', $id); // Assuming $data['wiki_id'] contains the ID of the wiki you want to update

            // Execute
            $this->db->execute();
            return true;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function delete_wiki($id){
        try {
            $this->db->query(" DELETE FROM wiki.wikis WHERE WikiID=:wiki_id");
            $this->db->bind(':wiki_id', $id );
            $this->db->execute();
            return  $this->db->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }
    public function archiver_wiki($id_wiki){
        try {
            $this->db->query("UPDATE wiki.wikis   SET archive = 0   where WikiID= :wiki_id");
            $this->db->bind(':wiki_id', $id_wiki );
            $this->db->execute();

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
