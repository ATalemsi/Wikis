<?php

class Wikis extends Controller
{
    private $wikismodel;
    private $tagmodel;
    private $categorymodel;



    public function __construct()
    {
        $this->wikismodel = $this->model('wiki');
        $this->tagmodel = $this->model('tag');
        $this->categorymodel = $this->model('categorie');


    }
    public function index()
    {
        // get wikis
        $recentPosts = $this->wikismodel->getRecentPosts(); // Adjust the method name accordingly
        $recentCategories = $this->categorymodel->getRecentCategories();

        $wikis = $this->wikismodel->get_wikis();

        $data = [
            'wikis' => $wikis,
            'recentPosts' => $recentPosts,
            'recentCategories' => $recentCategories
        ];
        $this->view('wikis/index', $data);
    }
    public function search() {
        if (isset($_GET['term'])) {
            $term = $_GET['term'];

            // Call the searchWikis method in the model
            $results = $this->wikismodel->searchWikis($term);

            // Return results as JSON
            header('Content-Type: application/json');
            echo json_encode($results);
        }
    }
    public function dashboard() {

        $totalWikis = $this->wikismodel->getTotalWikis();
        $mostProlificAuthor = $this->wikismodel->getMostProlificAuthor();
        $totalTags = $this->wikismodel->getTotalTags();
        $totalAuthors = $this->wikismodel->getTotalAuthors();
        $totalCategories = $this->wikismodel->getTotalCategories();
        $mostUsedCategory = $this->wikismodel->getMostUsedCategory();
        $data = [
            'totalWikis' => $totalWikis,
            'mostProlificAuthor' => $mostProlificAuthor,
            'totalTags' => $totalTags,
            'totalAuthors' => $totalAuthors,
            'totalCategories' => $totalCategories,
            'mostUsedCategory' => $mostUsedCategory,
        ];

        // Load the dashboard view with the retrieved data
        $this->view('wikis/dashboard',$data);
    }

    public function add()
    {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = [

                'CategoryID' => $_POST['categorieID'],
                'titre' => trim($_POST['titre']),
                'content' => trim($_POST['content']),
                'titre_err' => '',
                'content_err' => ''
            ];
            //Validate project_name
            if (empty($data['titre'])) {
                $data['titre_err'] = 'Please entre title name';
            }

            if (empty($data['content'])) {
                $data['content_err'] = 'Please entre description';
            }

            if (empty($data['titre_err']) && empty($data['content_err']) ) {
                //Validated
                $id_wiki = $this->wikismodel->add_wiki($data);
                if ($id_wiki) {

                    $selectedTagsString = $_POST['selected_tag_id'];


                    // Decode the JSON string to an array
                    $selectedTagsArray = json_decode($selectedTagsString, true);




                    $this->tagmodel->add_wiki_tags($id_wiki, $selectedTagsArray);


                    redirect('wikis');
                }else {
                die('Something went wrong ');
            }
            } else {
                //Load view with errors
                $this->view('wikis/add', $data);
            }
        } else {
            $data = [
                'categories' => $this->categorymodel->fetch_categories(),
                'tags' => $this->tagmodel->fetch_tags(),
                'selected_tags' => '',
                'titre' => '',
                'description' => '',
                'titre_err' => '',
                'description_err' => ''
            ];

            $this->view('wikis/add', $data);
        }
    }
}