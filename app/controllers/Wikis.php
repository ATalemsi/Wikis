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
    public function show($id)
    {
        $wiki = $this->wikismodel->getWikiById($id); // Implement this method in your model

        if ($wiki) {
            $data = [
                'wikis' => $wiki,
            ];

            $this->view('wikis/show', $data);
        }
    }
    public function search(){
        if (isset($_POST['input'])) {
            $input = $_POST['input'];

            $wikis = $this->wikismodel->found_wiki($input);


            foreach ($wikis as $wiki) {
                echo '<div  class="flex flex-col g-10 border-b-2 pb-8 border-gray-400">';
                echo '<h2 class="text-4xl font-bold mt-4 mb-2">' . $wiki->Title . '</h2>';
                echo '<p class="text-gray-700 mb-4">' . $wiki->Content . '.</p>';

                if (!empty($wiki->TagNames)) {
                    echo '<div class="flex flex-wrap gap-2 mt-4">';
                    $tags = explode(", ", $wiki->TagNames);
                    foreach ($tags as $tag) {
                        echo '<span class="bg-gray-300 p-2 rounded">' . $tag . '</span>';
                    }
                    echo '</div>';
                }

                echo '<div class="mt-4">';
                echo '<span class="bg-blue-300 p-2 rounded">' . $wiki->CategoryName . '</span>';
                echo '</div>';

                // Only show the buttons if the user is authenticated and owns the wiki
                echo '<div class="mt-4 ml-auto">';
                if ($wiki->AuthorID === $_SESSION['user_id'] && $_SESSION['UserRole'] == 'autheur') {
                    echo '<a href="' . URLROOT . '/wikis/edit/' . $wiki->WikiID . '" class="bg-green-500 text-white p-2 rounded">Update</a>';
                    echo '<a href="' . URLROOT . '/wikis/delete/' . $wiki->WikiID . '" class="bg-red-500 text-white p-2 rounded">Delete</a>';
                }

                if (isset($_SESSION['UserRole']) && $_SESSION['UserRole'] == 'admin') {
                    echo '<a href="' . URLROOT . '/wikis/archiver/' . $wiki->WikiID . '" class="bg-violet-500 text-white p-2 rounded">Archive</a>';
                }
                echo'  <a href=" '.URLROOT . '/wikis/show/' . $wiki->WikiID.'" class="bg-blue-500 text-white p-2 rounded">Show More</a>';

                echo '</div>';
                echo '</div>';
            };
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

                    $encoded_string  = $_POST['selected_tag_id'];


                    // Decode the JSON string to an array



                    $decoded_string = json_decode(html_entity_decode($encoded_string));



                    $this->tagmodel->add_wiki_tags($id_wiki, $decoded_string);


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
    public function edit($id)
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
                $this->wikismodel->update_wiki($id,$data);
                if( $this->tagmodel->delete_tags($id)){
                    $selectedTagsString = $_POST['selected_tag_id'];
                    // Decode the JSON string to an array
                    $decoded_string = json_decode(html_entity_decode($selectedTagsString));
                    $this->tagmodel->add_wiki_tags($id, $decoded_string);
                    redirect('wikis');
                }else {
                    die('Something went wrong ');
                }
            } else {
                //Load view with errors
                $this->view('wikis/add', $data);
            }
        } else {
            $wiki=$this->wikismodel->get_this_wikis($id);
            $category=$this->categorymodel->get_this_category($wiki->CategoryID);
            $tags=$this->tagmodel-> get_tags_wiki($id);
            $data = [
                'wiki'=>$wiki,
                'mycategories' => $category,
                'mytags' => $tags,
                'categories' => $this->categorymodel->fetch_categories(),
                'tags' => $this->tagmodel->fetch_tags(),
                'selected_tags' => '',
                'titre_err' => '',
                'description_err' => ''
            ];

            $this->view('wikis/edit', $data);
        }
    }
    public function archiver($id_wiki){
        $this->wikismodel->archiver_wiki($id_wiki);
        redirect('wikis/index');
    }

}