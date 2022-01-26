<?php
require_once(ROOT_PATH .'/Models/Db.php');

class User extends Db{
    private $table = "user";

    public function __construct($dbh = null){
        parent::__construct($dbh);
    }

    public function findUser($user){
      try{
        $sql = "SELECT * FROM " .$this->table. " WHERE email = :email";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':email', $user["email"], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(isset($result['password'])) {
          if(password_verify($user['password'],$result['password'])) {
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

    public function insert($user){
      try{
        $sql = 'INSERT INTO ' .$this->table. ' (name, email, password)
                  VALUES(:name, :email, :password)';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':name', $user['name'], PDO::PARAM_STR);
        $sth->bindParam(':email', $user['email'], PDO::PARAM_STR);
        $password = password_hash($user['password'], PASSWORD_DEFAULT);
        $sth->bindParam(':password', $password, PDO::PARAM_STR);
        $sth->execute();
      }catch(PDOException $e){
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    public function find_user_name($id){
      try{
        $sql = 'SELECT name FROM ' .$this->table. ' WHERE id=:id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
      }catch(PDOException $e){
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }
    
}