<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Like extends Db{
    private $table = "`like`";

    public function __construct($dbh = null){
        parent::__construct($dbh);
    }

    public function checkLike($arr){
        try{
            $sql = "SELECT * FROM `like` WHERE user_id = :user_id AND post_id = :post_id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(':user_id', $arr["user_id"], PDO::PARAM_INT);
            $stmt->bindValue(':post_id', $arr["post_id"], PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
          }catch(PDOException $e){
            echo 'データベースにアクセスできません！'.$e->getMessage();
            exit;
          }
    }

    public function deleteLike($arr){
        $sql = 'DELETE FROM `like` WHERE user_id = :user_id AND post_id = :post_id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $arr["user_id"], PDO::PARAM_INT);
        $sth->bindParam(':post_id', $arr["post_id"], PDO::PARAM_INT);
        $sth->execute();
    }

    public function insertLike($arr){
        try{
            $sql = "INSERT INTO `like`(user_id, post_id) VALUES(:user_id, :post_id)";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(':user_id', $arr["user_id"], PDO::PARAM_INT);
            $stmt->bindValue(':post_id', $arr["post_id"], PDO::PARAM_INT);
            $stmt->execute();
          }catch(PDOException $e){
            echo 'データベースにアクセスできません！'.$e->getMessage();
            exit;
          }
    }

    public function countLike($id){
      try{
        $sql = "SELECT count(*) as count FROM `like` WHERE post_id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
      }catch(PDOException $e){
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }
}