<?php
  class Users extends Controller {
    private $userModel;
    public function __construct(){
      $this->userModel = $this->model('User');
    }

    public function register(){
      // Check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process form
  
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        // Init data
        $data =[
          'firstname' => trim($_POST['firstname']),
          'lastname' => trim($_POST['lastname']),
          'Email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'UserRole' => 'autheur',
          'firstname_err' => '',
          'lastname_err' => '',
          'email_err' => '',
          'password_err' => '',
        ];

        // Validate Email
        if(empty($data['Email'])){
          $data['email_err'] = 'Pleae enter email';
        } else {
          // Check email
          if($this->userModel->findUserByEmail($data['Email'])){
            $data['email_err'] = 'Email is already taken';
          }
        }

        // Validate Name
          if(empty($data['firstname'])){
              $data['firstname_err'] ='Please write your firstname';
          }
          if(empty($data['lastname'])){
              $data['lastname_err'] ='Please write your lastname';
          }
        // Validate Password
        if(empty($data['password'])){
          $data['password_err'] = 'Pleae enter password';
        } elseif(strlen($data['password']) < 6){
          $data['password_err'] = 'Password must be at least 6 characters';
        }
        // Make sure errors are empty
        if(empty($data['email_err']) && empty($data['firstname_err']) && empty($data['lastname_err']) && empty($data['password_err'])){
          // Validated
          
          // Hash Password
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

          // Register User
          if($this->userModel->register($data)){
            flash('register_success', 'You are registered and can log in');
            redirect('users/login');
          } else {
            die('Something went wrong');
          }

        } else {
          // Load view with errors
          $this->view('users/register', $data);
        }

      } else {
        // Init data
        $data =[
          'firstname' => '',
          'lastname' => '',
          'Email' => '',
          'password' => '',
          'firstname_err' => '',
          'lastname_err' => '',
          'email_err' => '',
          'password_err' => ''
        ];

        // Load view
        $this->view('users/register', $data);
      }
    }

    public function login(){
      // Check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process form
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        
        // Init data
        $data =[
          'Email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'email_err' => '',
          'password_err' => '',
        ];
        // Validate Email
        if(empty($data['Email'])){
          $data['email_err'] = 'Pleae enter email';
        }

        // Validate Password
        if(empty($data['password'])){
          $data['password_err'] = 'Please enter password';
        }

        // Check for user/email
        if($this->userModel->findUserByEmail($data['Email'])){
          // User found
        } else {
          // User not found
          $data['email_err'] = 'No user found';
        }

        // Make sure errors are empty
        if(empty($data['email_err']) && empty($data['password_err'])){
          // Validated
          // Check and set logged in user
          $loggedInUser = $this->userModel->login($data['Email'], $data['password']);
          if($loggedInUser){

            // Create Session
            $this->createUserSession($loggedInUser);
          } else {
            $data['password_err'] = 'Password incorrect';

            $this->view('users/login', $data);
          }
        } else {
          // Load view with errors
          $this->view('users/login', $data);
        }


      } else {
        // Init data
        $data =[
          'Email' => '',
          'password' => '',
          'email_err' => '',
          'password_err' => '',
        ];

        // Load view
        $this->view('users/login', $data);
      }
    }

    public function createUserSession($user){
      $_SESSION['user_id'] = $user->ID_User;
      $_SESSION['user_email'] = $user->Email;
      $_SESSION['firstname'] = $user->Firstname;
      $_SESSION['UserRole'] = $user->UserRole;
      if($_SESSION['UserRole']== 'admin' ){
          redirect('wikis/dashboard');
      }else{
          redirect('wikis/index');
      }
    }

    public function logout(){
      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']);
      unset($_SESSION['firstname']);
      unset($_SESSION['UserRole']);
      session_destroy();
      redirect('users/login');
    }

    public function isLoggedIn(){
      if(isset($_SESSION['user_id'])){
        return true;
      } else {
        return false;
      }
    }
  }