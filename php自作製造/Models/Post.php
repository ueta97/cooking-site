<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Post extends Db{
    private $table = "post";

    public function __construct($dbh = null){
      parent::__construct($dbh);
    }

    // postテーブルから全てのデータを取得（10件ずつ表示）
    public function findAllRank($page = 0):Array{
        $sql = "SELECT post.*, producer.name as producer_name FROM ".$this->table. " JOIN producer ON post.producer_id = producer.id";
        $sql .= ' ORDER BY like_count DESC LIMIT 10 OFFSET '.(10 * $page);
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function findAll($page = 0):Array{
      $sql = "SELECT post.*, producer.name as producer_name FROM ".$this->table. " JOIN producer ON post.producer_id = producer.id";
      $sql .= ' ORDER BY created_at DESC LIMIT 10 OFFSET '.(10 * $page);
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
  }

    public function searchPost($page, $search):Array{
      $sql = "SELECT post.*, producer.name as producer_name FROM ".$this->table. " JOIN producer ON post.producer_id = producer.id";
      $sql .= ' WHERE title LIKE :search OR main_item LIKE :search ORDER BY created_at DESC LIMIT 10 OFFSET '.(10 * $page);
      $sth = $this->dbh->prepare($sql);
      $search_txt = "%".$search."%";
      $sth->bindParam(":search",$search_txt,PDO::PARAM_STR);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
  }

  public function searchPostRank($page, $search):Array{
    $sql = "SELECT post.*, producer.name as producer_name FROM ".$this->table. " JOIN producer ON post.producer_id = producer.id";
    $sql .= ' WHERE title LIKE :search OR main_item LIKE :search ORDER BY like_count DESC LIMIT 10 OFFSET '.(10 * $page);
    $sth = $this->dbh->prepare($sql);
    $search_txt = "%".$search."%";
    $sth->bindParam(":search",$search_txt,PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

    // postテーブルから指定idに一致するデータを取得
    public function findById($id = 0):Array{
      $sql = "SELECT post.*, producer.name as producer_name FROM ".$this->table. " JOIN producer ON post.producer_id = producer.id";
        $sql .= " WHERE " .$this->table. " .id = :id";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(":id",$id,PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // postテーブルから全てのデータ数を取得
    public function countAll():Int{
        $sql = "SELECT count(*) FROM ".$this->table;
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchColumn();
        return $result;
    }

    public function countById($id):Int{
      $sql = "SELECT count(*) FROM ".$this->table. " WHERE producer_id = :producer_id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(":producer_id",$id,PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetchColumn();
      return $result;
    }

    public function countBySearch($search):Int{
      $sql = "SELECT count(*) FROM ".$this->table. " WHERE title LIKE :search OR main_item LIKE :search";
      $sth = $this->dbh->prepare($sql);
      $search_txt = "%".$search."%";
      $sth->bindParam(":search",$search_txt,PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetchColumn();
      return $result;
    }

    public function countByLike($id):Int{
      $sql = "SELECT count(*) FROM ".$this->table. " JOIN `like` ON post.id = `like`.post_id WHERE `like`.user_id = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetchColumn();
      return $result;
    }

    public function findMyPost($page,$producer):Array{
        $sql = "SELECT * FROM ".$this->table. " WHERE producer_id = :producer_id";
        $sql .= ' ORDER BY created_at DESC LIMIT 10 OFFSET '.(10 * $page);
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(":producer_id",$producer,PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function create($arr, $check) {
        try {
          $sql = 'INSERT INTO ' .$this->table. ' (producer_id, title, image, comment, item, cooking, main_item, main_image, check1, check2, check3, check4) 
            VALUES (:producer_id, :title, :image, :comment, :item, :cooking, :main_item, :main_image, :check1, :check2, :check3, :check4)';
          $sth = $this->dbh->prepare($sql);
          $sth->bindParam(':producer_id', $arr['producer_id'], PDO::PARAM_STR);
          $sth->bindParam(':title', $arr['title'], PDO::PARAM_STR);
          $sth->bindParam(':image', $arr['image'], PDO::PARAM_STR);
          $sth->bindParam(':comment', $arr['comment'], PDO::PARAM_STR);
          $sth->bindParam(':item', $arr['item'], PDO::PARAM_STR);
          $sth->bindParam(':cooking', $arr['cooking'], PDO::PARAM_STR);
          $sth->bindParam(':main_item', $arr['main_item'], PDO::PARAM_STR);
          $sth->bindParam(':main_image', $arr['main_image'], PDO::PARAM_STR);
          $sth->bindParam(':check1', $check[0], PDO::PARAM_INT);
          $sth->bindParam(':check2', $check[1], PDO::PARAM_INT);
          $sth->bindParam(':check3', $check[2], PDO::PARAM_INT);
          $sth->bindParam(':check4', $check[3], PDO::PARAM_INT);
          $sth->execute();
        } catch(PDOException $e) {
          echo 'データベースにアクセスできません！'.$e->getMessage();
          exit;
        }
    }

    public function update($arr, $check) {
      try {
        $sql = 'UPDATE ' .$this->table. ' SET title=:title, comment=:comment, item=:item, cooking=:cooking, main_item=:main_item, check1=:check1, check2=:check2, check3=:check3, check4=:check4 WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $arr['id'], PDO::PARAM_INT);
        $sth->bindParam(':title', $arr['title'], PDO::PARAM_STR);
        $sth->bindParam(':comment', $arr['comment'], PDO::PARAM_STR);
        $sth->bindParam(':item', $arr['item'], PDO::PARAM_STR);
        $sth->bindParam(':cooking', $arr['cooking'], PDO::PARAM_STR);
        $sth->bindParam(':main_item', $arr['main_item'], PDO::PARAM_STR);
        $sth->bindParam(':check1', $check[0], PDO::PARAM_INT);
        $sth->bindParam(':check2', $check[1], PDO::PARAM_INT);
        $sth->bindParam(':check3', $check[2], PDO::PARAM_INT);
        $sth->bindParam(':check4', $check[3], PDO::PARAM_INT);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    public function delete($id){
      $sql = 'UPDATE ' .$this->table. ' SET del_flg = 1';
      $sql .= ' WHERE id = :id';
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();
    }

    public function updateImage($arr) {
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

    public function updateMainImage($arr) {
      try {
        $sql = 'UPDATE ' .$this->table. ' SET main_image=:main_image WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $arr['id'], PDO::PARAM_INT);
        $sth->bindParam(':main_image', $arr['image'], PDO::PARAM_STR);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    public function likePost($page, $user):Array{
      $sql = "SELECT post.*, producer.name as producer_name FROM ".$this->table. " JOIN producer ON post.producer_id = producer.id JOIN `like` ON post.id = `like`.post_id WHERE `like`.user_id = :id ";
      $sql .= ' ORDER BY created_at DESC LIMIT 10 OFFSET '.(10 * $page);
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $user['id'], PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }

    public function insertLike($id){
      try {
        $sql = 'UPDATE ' .$this->table. ' SET like_count=like_count+1 WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    public function deleteLike($id){
      try {
        $sql = 'UPDATE ' .$this->table. ' SET like_count=like_count-1 WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
      } catch(PDOException $e) {
        echo 'データベースにアクセスできません！'.$e->getMessage();
        exit;
      }
    }

    
}