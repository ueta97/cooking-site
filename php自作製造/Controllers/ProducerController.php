<?php
require_once(ROOT_PATH .'/Models/Producer.php');

class ProducerController{

    private $request; // リクエストパラメータ
    private $Producer;  // Producerモデル

    public function __construct() {

        // リクエストパラメータの取得
          $this->request['get'] = $_GET;
          $this->request['post'] = $_POST;
          $this->Producer = new Producer();

    }

    public function login(){
      $login_producer = [
        'email' => $this->request['post']['email'],
        'password' => $this->request['post']['password']
      ];
      $producer = $this->Producer->findProducer($login_producer);
      $params = [
        "producer" => $producer
      ];
      return $params;
    }

    public function findMail(){
      $email = $this->request['post']['email'];
      $producer = $this->Producer->findMail($email);
      $params = [
        "producer" => $producer
      ];
      return $params;
    }

    public function pass(){
      $login_user = [
        'email' => $this->request['post']['email'],
        'password' => $this->request['post']['password']
      ];
      $user = $this->Producer->pass($login_user);
    }

    public function getAll(){
      $producers = $this->Producer->findAll();
      $params = [
        "producers" => $producers
      ];
      return $params;
    }

    public function signUp($save_filename){
      $login_producer = [
        "name" => $this->request["post"]["name"],
        'email' => $this->request['post']['email'],
        'password' => $this->request['post']['password'],
        'pr' => $this->request['post']['pr'],
        "image" => $save_filename,
        "url" => $this->request['post']['url']
      ];
      $this->Producer->insert($login_producer);
    }

    public function info(){
      if(empty($this->request['get']['producer_id'])){
          echo '指定のパラメータが不正です。このページを表示できません。';
          exit;
      }

      $producer = $this->Producer->findById($this->request["get"]["producer_id"]);
      $params = [
          "producer" => $producer
      ];

      return $params;
  
  }

  public function update(){
    $update_producer = [
        "id" => $this->request["post"]["id"],
        "name" => $this->request["post"]["name"],
        "pr" => $this->request["post"]["pr"],
        "url" => $this->request["post"]["url"]
    ];

    $this->Producer->update($update_producer);

}

public function updateProducerImage($filename){
  $update_image = [
      "id" => $this->request["post"]["id"],
      "image" => $filename
  ];

  $this->Producer->updateProducerImage($update_image);

}

}