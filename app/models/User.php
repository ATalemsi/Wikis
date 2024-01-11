<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Regsiter user
    public function register($data){
      $this->db->query('INSERT INTO wiki.users (Firstname,Lastname, Email, PasswordHash,UserRole) VALUES(:firstname,:lastname, :Email, :PasswordHash,:UserRole)');
      // Bind values
      $this->db->bind(':firstname', $data['firstname']);
      $this->db->bind(':lastname', $data['lastname']);
      $this->db->bind(':Email', $data['Email']);
      $this->db->bind(':PasswordHash', $data['password']);
      $this->db->bind(':UserRole', $data['UserRole']);
      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Login User
    public function login($email, $password){
      $this->db->query('SELECT * FROM wiki.users WHERE Email = :Email');
      $this->db->bind(':Email', $email);

      $row = $this->db->single();

      $hashed_password = $row->PasswordHash;
      if(password_verify($password, $hashed_password)){
        return $row;
      } else {
        return false;
      }
    }

    // Find user by email
    public function findUserByEmail($email){
      $this->db->query('SELECT * FROM wiki.users WHERE Email = :Email');
      // Bind value
      $this->db->bind(':Email', $email);

      $this->db->single();

      // Check row
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }
  }