<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Comment extends Db{
    private $table = "comment";

    public function __construct($dbh = null){
        parent::__construct($dbh);
    }

    public function sendComment($arr){
        try{
            $sql = "INSERT INTO " .$this->table. ' (user_id, post_id, comment) VALUES(:user_id, :post_id, :comment)';
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':user_id', $arr["user_id"], PDO::PARAM_INT);
            $stmt->bindParam(':post_id', $arr["post_id"], PDO::PARAM_INT);
            $stmt->bindParam(':comment', $arr["comment"], PDO::PARAM_STR);
            $stmt->execute();
          }catch(PDOException $e){
            echo 'データベースにアクセスできません！'.$e->getMessage();
            exit;
          }
    }

    public function findComment($id){
        $sql = "SELECT comment.*, user.name as user_name FROM ".$this->table. " JOIN user ON comment.user_id = user.id";
        $sql .= " WHERE " .$this->table. " .post_id = :id ORDER BY created_at DESC";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(":id",$id,PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function deleteComment($id){
        try{
            $sql = "DELETE FROM " .$this->table. ' WHERE id=:id';
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
          }catch(PDOException $e){
            echo 'データベースにアクセスできません！'.$e->getMessage();
            exit;
          }
    }

}