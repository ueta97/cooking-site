<?php
require_once(ROOT_PATH .'/Models/User.php');

class UserController{

    private $request; // リクエストパラメータ
    private $User;  // Userモデル

    public function __construct() {

        // リクエストパラメータの取得
          $this->request['get'] = $_GET;
          $this->request['post'] = $_POST;
          $this->User = new User();

    }

    public function login(){
      $login_user = [
        'email' => $this->request['post']['email'],
        'password' => $this->request['post']['password']
      ];
      $user = $this->User->findUser($login_user);
      $params = [
        "user" => $user
      ];
      return $params;
    }

    public function findMail(){
      $email = $this->request['post']['email'];
      $user = $this->User->findMail($email);
      $params = [
        "user" => $user
      ];
      return $params;
    }

    public function pass(){
      $login_user = [
        'email' => $this->request['post']['email'],
        'password' => $this->request['post']['password']
      ];
      $user = $this->User->pass($login_user);
    }

    public function getAll(){
      $users = $this->User->findAll();
      $params = [
        "users" => $users
      ];
      return $params;
    }

    public function signUp(){
      $login_user = [
        "name" => $this->request["post"]["name"],
        'email' => $this->request['post']['email'],
        'password' => $this->request['post']['password']
      ];
      $this->User->insert($login_user);
    }

}