<?php

class Tags extends Controller
{
    private $tagsModel;

    public function __construct()
    {
        $this->tagsModel = $this->model('Tag'); // Assuming you have a model named TagModel
    }

    public function index()
    {
        $tags = $this->tagsModel->fetch_tags();

        $data = [
            'tags' => $tags
        ];

        $this->view('tags/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = [
                'tag_name' => trim($_POST['tagName']),
                'user_id' => $_SESSION['user_id'],
                'tag_name_error' => ''
            ];

            if (empty($data['tag_name'])) {
                $data['tag_name_error'] = 'Please enter Tag name';
            }

            if (empty($data['tag_name_error'])) {
                if ($this->tagsModel->addTag($data)) {
                    flash('tag_message', 'Tag Added');
                    redirect('tags');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('tags/index', $data);
            }
        } else {
            $data = [
                'tag_name' => ''
            ];
            $this->view('tags/index', $data);
        }
    }

    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = [
                'TagID' => $_POST['tagId'],
                'tag_name' => trim($_POST['tagName']),
                'tag_name_error' => ''
            ];

            // Validate category_name
            if (empty($data['tag_name'])) {
                $data['tag_name_error'] = 'Please enter Tag name';
            }


            // Make sure no errors
            if (empty($data['tag_name_error'])) {
                // Validated
                if ($this->tagsModel->updateTag($data)) {
                    flash('tag_message', 'Tag Modified');
                    redirect('tags');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('tags/index', $data);
            }

        } else {
            // Get existing category from model
            $id =$_POST['tagId'];
            $tag = $this->tagsModel->getTagId($id);
            // Check for owner
            if ($tag->created_id != $_SESSION['user_id']) {
                redirect('categories');
            }

            $data = [
                'TagID' =>$id,
                'tag_name' => $tag->TagName
            ];


            $this->view('tags/index', $data);
        }
    }

    public function delete($id)
    {
        if ($this->tagsModel->deleteTag($id)) {
            flash('tag_message', 'Tag Deleted');
            redirect('tags');
        } else {
            die('Something went wrong');
        }
    }
}
