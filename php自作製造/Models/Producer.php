<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Producer extends Db{
    private $table = "producer";

    public function __construct($dbh = null){
        parent::__construct($dbh);
    }

    public function findProducer($producer){
      try{
        $sql = "SELECT * FROM " .$this->table. " WHERE email = :email";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':email', $producer["email"], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(isset($result['password'])) {
          if(password_verify($producer['password'],$result['password'])) {
            return $result;
          }
        }
      }catch(PDOException $e){
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    public function findMail($email){
      try{
        $sql = "SELECT * FROM " .$this->table. " WHERE email = :email";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
      }catch(PDOException $e){
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    public function pass($user){
      try{
        $sql = 'UPDATE ' .$this->table. ' SET password=:password WHERE email = :email';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':email', $user["email"], PDO::PARAM_STR);
        $password = password_hash($user['password'], PASSWORD_DEFAULT);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
      }catch(PDOException $e){
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    public function findAll(){
      try{
        $sql = "SELECT * FROM " .$this->table;
        $sth = $this->dbh->query($sql);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      }catch(PDOException $e){
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    public function insert($producer){
      try{
        $sql = 'INSERT INTO ' .$this->table. ' (name, email, password, pr, image, url) 
                  VALUES(:name, :email, :password, :pr, :image, :url)';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':name', $producer['name'], PDO::PARAM_STR);
        $sth->bindParam(':email', $producer['email'], PDO::PARAM_STR);
        $password = password_hash($producer['password'], PASSWORD_DEFAULT);
        $sth->bindParam(':password', $password, PDO::PARAM_STR);
        $sth->bindParam(':pr', $producer['pr'], PDO::PARAM_STR);
        $sth->bindParam(':image', $producer['image'], PDO::PARAM_STR);
        $sth->bindParam(':url', $producer['url'], PDO::PARAM_STR);
        $sth->execute();
      }catch(PDOException $e){
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    public function findById($id = 0):Array{
      $sql = "SELECT * FROM ".$this->table;
      $sql .= " WHERE id = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(":id",$id,PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);
      return $result;
    }

    public function update($arr) {
      try {
        $sql = 'UPDATE ' .$this->table. ' SET name=:name, pr=:pr, url=:url WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $arr['id'], PDO::PARAM_INT);
        $sth->bindParam(':name', $arr['name'], PDO::PARAM_STR);
        $sth->bindParam(':pr', $arr['pr'], PDO::PARAM_STR);
        $sth->bindParam(':url', $arr['url'], PDO::PARAM_STR);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    public function updateproducerImage($arr) {
      try {
        $sql = 'UPDATE ' .$this->table. ' SET image=:image WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $arr['id'], PDO::PARAM_INT);
        $sth->bindParam(':image', $arr['image'], PDO::PARAM_STR);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    
}