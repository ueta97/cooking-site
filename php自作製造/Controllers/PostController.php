<?php

require_once(ROOT_PATH."/Models/Post.php");
require_once(ROOT_PATH."/Models/Producer.php");
require_once(ROOT_PATH."/Models/like.php");
require_once(ROOT_PATH."/Models/Comment.php");
require_once(ROOT_PATH."/Models/User.php");

class PostController {
    private $request; //リクエストパラメータ
    private $Post; //Postモデル
    private $Producer;
    private $Like;
    private $User;
    private $Comment;

    public function __construct(){
        //リクエストパラメータの取得
        $this->request["get"] = $_GET;
        $this->request["post"] = $_POST;

        //モデルオブジェクトの生成
        $this->Post = new Post();

        $dbh = $this->Post->get_db_handler();
        $this->Producer = new Producer($dbh);
        $this->Like = new Like($dbh);
        $this->Comment = new Comment($dbh);
        $this->User = new User($dbh);
    }

    public function indexRank(){
        $page = 0;
        if(isset($this->request["get"]["page"])){
            $page = $this->request["get"]["page"];
        }

        $post = $this->Post->findAllRank($page);
        $post_count = $this->Post->countAll();

        $params = [
            "post" => $post,
            "pages" => $post_count / 10,
        ];

        return $params;
    }

    public function index(){
        $page = 0;
        if(isset($this->request["get"]["page"])){
            $page = $this->request["get"]["page"];
        }

        $post = $this->Post->findAll($page);
        $post_count = $this->Post->countAll();

        $params = [
            "post" => $post,
            "pages" => $post_count / 10,
        ];

        return $params;
    }

    public function searchPost(){
        $page = 0;
        if(isset($this->request["get"]["page"])){
            $page = $this->request["get"]["page"];
        }
        $search = $this->request["get"]["search"];
        

        $post = $this->Post->searchPost($page, $search);
        $post_count = $this->Post->countBySearch($search);

        $params = [
            "post" => $post,
            "pages" => $post_count / 10,
        ];

        return $params;
    }

    public function searchPostRank(){
        $page = 0;
        if(isset($this->request["get"]["page"])){
            $page = $this->request["get"]["page"];
        }
        $search = $this->request["get"]["search"];
        

        $post = $this->Post->searchPostRank($page, $search);
        $post_count = $this->Post->countBySearch($search);

        $params = [
            "post" => $post,
            "pages" => $post_count / 10,
        ];

        return $params;
    }

    public function detail(){
        if(empty($this->request['get']['id'])){
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }

        $post = $this->Post->findById($this->request["get"]["id"]);
        $params = [
            "post" => $post
        ];

        return $params;
    
    }

    public function myPost($producer){
        $page = 0;
        if(isset($this->request["get"]["page"])){
            $page = $this->request["get"]["page"];
        }

        $post = $this->Post->findMyPost($page,$producer);
        $post_count = $this->Post->countById($producer);
        $params = [
            "post" => $post,
            "pages" => $post_count / 10
        ];

        return $params;
    }

    public function infoPost(){
        $page = 0;
        if(isset($this->request["get"]["page"])){
            $page = $this->request["get"]["page"];
        }

        $producer = [
            "id" => $_GET["producer_id"]
        ];

        $post = $this->Post->findMyPost($page,$producer);
        $post_count = $this->Post->countById($producer);
        $params = [
            "post" => $post,
            "pages" => $post_count / 10
        ];

        return $params;
    }

    public function create($img_arr, $check){
        $create_post = [
            "producer_id" => $_SESSION['user']["id"],
            "title" => $this->request["post"]["title"],
            "image" => $img_arr[0],
            "comment" => $this->request["post"]["comment"],
            "item" => $this->request["post"]["item"],
            "cooking" => $this->request["post"]["cooking"],
            "main_item" => $this->request["post"]["main_item"],
            "main_image" => $img_arr[1]
        ];

        $this->Post->create($create_post, $check);

    }

    public function update(){
        $update_post = [
            "id" => $this->request["post"]["id"],
            "title" => $this->request["post"]["title"],
            "comment" => $this->request["post"]["comment"],
            "item" => $this->request["post"]["item"],
            "cooking" => $this->request["post"]["cooking"],
            "main_item" => $this->request["post"]["main_item"],
        ];

        $check = $this->request["post"]["check"];

        $this->Post->update($update_post, $check);

    }

    public function delete(){
        $this->Post->delete($this->request['get']['id']);
    }

    public function updateImage($filename){
        $update_image = [
            "id" => $this->request["post"]["id"],
            "image" => $filename
        ];

        $this->Post->updateImage($update_image);

    }

    public function updateMainImage($filename){
        $update_image = [
            "id" => $this->request["post"]["id"],
            "image" => $filename
        ];

        $this->Post->updateMainImage($update_image);

    }

    public function checkLike($user_id, $post_id){
        $params = [
            "user_id" => $user_id,
            "post_id" => $post_id
        ];

        $checkLike = $this->Like->checkLike($params);
        return $checkLike;
    }

    public function deleteLike($user_id, $post_id){
        $params = [
            "user_id" => $user_id,
            "post_id" => $post_id
        ];

        $this->Like->deleteLike($params);
        $this->Post->deleteLike($post_id);
    }

    public function insertLike($user_id, $post_id){
        $params = [
            "user_id" => $user_id,
            "post_id" => $post_id
        ];

        $this->Like->insertLike($params);
        $this->Post->insertLike($post_id);
    }

    public function sendComment($arr){
        $params = [
            "user_id" => $arr[0],
            "post_id" => $arr[1],
            "comment" => $arr[2]
        ];

        $this->Comment->sendComment($params);
    }

    public function findComment($id){
        $comment = $this->Comment->findComment($id);
        $params = [
            "comment" => $comment
        ];

        return $params;
    
    }

    public function countLike($post_id){
        $count = $this->Like->countLike($post_id);
        return $count;
    }

    public function likePost(){
        $page = 0;
        if(isset($this->request["get"]["page"])){
            $page = $this->request["get"]["page"];
        }

        $user = $_SESSION["user"];

        $post = $this->Post->likePost($page, $user);
        $post_count = $this->Post->countByLike($user["id"]);

        $params = [
            "post" => $post,
            "pages" => $post_count / 10,
        ];

        return $params;
    }

    public function find_user_name($id){
        $user_name = $this->User->find_user_name($id);
        return $user_name;
    }

    public function deleteComment(){
        $id = $this->request["get"]["id"];
        $this->Comment->deleteComment($id);
    }
    
}