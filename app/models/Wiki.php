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
            c.CategoryID,
            c.CategoryName,
            GROUP_CONCAT(t.TagName SEPARATOR " , ") AS TagNames
        FROM
            wiki.wikis w
        JOIN wiki.categories c ON w.CategoryID = c.CategoryID
        LEFT JOIN wiki.wikitags wt ON w.WikiID = wt.WikiID
        LEFT JOIN wiki.tags t ON wt.TagID = t.TagID
        WHERE
            w.archive = 1
        GROUP BY
            w.WikiID
        ORDER BY
            w.CreationDate DESC
    ');

        return $this->db->resultSet();
    }
public function searchWikis($term) {
    // Prepare the SQL query to search for wikis
    $sql = "
            SELECT
                w.WikiID,
                w.Title,
                w.Content,
                c.CategoryID,
                c.CategoryName,
                GROUP_CONCAT(t.TagName SEPARATOR ', ') AS TagNames
            FROM
                wiki.wikis w
            JOIN wiki.categories c ON w.CategoryID = c.CategoryID
            LEFT JOIN wiki.wikitags wt ON w.WikiID = wt.WikiID
            LEFT JOIN wiki.tags t ON wt.TagID = t.TagID
            WHERE
                w.Title LIKE :term OR
                c.CategoryName LIKE :term OR
                t.TagName LIKE :term
            GROUP BY
                w.WikiID
            ORDER BY
                w.CreationDate DESC
        ";

    // Prepare the parameters for the query
    $params = [':term' => "%$term%"];

    // Execute the query
    $this->db->query($sql, $params);

    // Fetch the results
    $results = $this->db->resultSet();
    header('Content-Type: application/json');
    echo json_encode($results ?: null);

    return $results;
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
    public function get_this_wikis($id_wiki){

        $this->db->query(" SELECT * FROM wiki.wikis WHERE WikiID=:wiki_id");
        $this->db->bind(':wiki_id', $id_wiki );
        $this->db->execute();
        return  $this->db->single();

    }
    public function getRecentPosts($limit = 5)
    {
        $this->db->query('
            SELECT
                WikiID,
                Title
            FROM
                wiki.wikis
            ORDER BY
                CreationDate DESC
            LIMIT :limit
        ');

        $this->db->bind(':limit', $limit);

        return $this->db->resultSet();
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
        $this->db->query('SELECT COUNT(DISTINCT AuthorID) as totalAuthors FROM wiki.wikis');
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
}
