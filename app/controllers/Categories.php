<?php

class Categories extends Controller
{
    private $categoriesmodel;

    public function __construct()
    {
        $this->categoriesmodel = $this->model('categorie');
    }
    public function index()
    {
        // get Projects

        $categories = $this->categoriesmodel->getCategories();

        $data = [
            'categories' => $categories
        ];

        $this->view('categories/index', $data);
    }
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = [
                'categorie_name' => trim($_POST['categoryName']),
                'user_id' => $_SESSION['user_id'],
                'categorie_name_error' => ''

            ];
            //Validate project_name
            if (empty($data['categorie_name'])) {
                $data['categorie_name_error'] = 'Please entre Categorie name';
            }

            //Make sure no errors
            if (empty($data['categorie_name_error'])) {
                //Validated

                if ($this->categoriesmodel->addCategorie($data)) {
                    flash('categorie_message', 'categorie Added');
                    redirect('categories');

                } else {
                    die('Something went wrong ');
                }


            } else {
                //Load view with errors
                $this->view('categories/index', $data);
            }

        } else {
            $data = [
                'categorie_name' => '',

            ];
            $this->view('categories/index', $data);
        }

    }
    public function edit()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = [
                'CategoryID' => $_POST['categoryId'],
                'categorie_name' => trim($_POST['categoryName']),
                'categorie_name_error' => ''
            ];

            // Validate category_name
            if (empty($data['categorie_name'])) {
                $data['categorie_name_error'] = 'Please enter Category name';
            }


            // Make sure no errors
            if (empty($data['categorie_name_error'])) {
                // Validated
                if ($this->categoriesmodel->updateCategorie($data)) {
                    flash('categories_message', 'Category Modified');
                    redirect('categories');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('categories/index', $data);
            }

        } else {
            // Get existing category from model
            $id =$_POST['categoryId'];
            $category = $this->categoriesmodel->getCategorieId($id);
            // Check for owner
            if ($category->created_AdminID != $_SESSION['UserID']) {
                redirect('categories');
            }

            $data = [
                'CategoryID' =>$id,
                'categorie_name' => $category->CategoryName
            ];


            $this->view('categories/index', $data);
        }
    }
    public function delete($id)
    {
        if ($this->categoriesmodel->deleteCategory($id)) {
            flash('category_message', 'categorie Deleted');
            redirect('categories');
        } else {
            die('Something went wrong');
        }
    }
}