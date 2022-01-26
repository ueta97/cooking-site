<?php
session_start();
require_once(ROOT_PATH .'Controllers/PostController.php');
$post = new PostController();

function h($s){
  return htmlspecialchars($s,ENT_QUOTES,"UTF-8");
}

$params = $post->indexRank();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>投稿一覧画面</title>
  <link rel="stylesheet" type="text/css" href="/css/base.css">
</head>
<body>
  <div class="all">
    <div class="header">
      <div class="header-left">
        <div class="site-title">
          <a href="index.php"><h1>ファーマーズレシピ</h1></a>
        </div>
        <div class="page-name">
            <h2>投稿一覧　</h2>
        </div>
      </div>
      <div class="header-right">
        <?php include("header.php"); ?>
      </div>
    </div>
    <div class="search">
      <form action="searchRank.php" method="get">
        <input type="text"  class="search-txt" name="search" placeholder="料理名/食材"value="<?php if(isset($_GET["search"])){echo h($_GET["search"]);} ?>">
        <input type="submit" class="search-btn" value="検索">
      </form>
      <select onChange="location.href=value;">
        <option value="">いいね順</option>
        <option value="index.php">新しい順</option>
        </select>
    </div>
    <div class="main">
    <?php if($_SESSION['user']['role'] == 1): ?>
      <button onclick="location.href='create.php'" class="btn create-btn">投稿</button>
    <?php endif; ?>
      <?php foreach($params["post"] as $param): ?>
        <?php if($param['del_flg'] == 0): ?>
          <div class="posts">
            <div class="posts-left">
              <a href="detailPost.php?id=<?=$param['id'] ?>" class="posts-image"><img src="../Image/<?=$param["image"]; ?>"></a>
            </div>
            <div class="posts-right">
              <a href="detailPost.php?id=<?=$param['id'] ?>" class="posts-title"><h2><?=$param["title"] ?></h2></a>
              <a href="detailProducer.php?producer_id=<?=$param['producer_id'] ?>" class="posts-producer">投稿者：<?=$param['producer_name'] ?>さん</a>
              <?php $countLike = $post->countLike($param['id']); ?>
              <p>いいね数　<?= $countLike["count"]; ?></p>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

<div class="pages">
  <?php
  for($i=0;$i<=$params["pages"];$i++){
    if(isset($_GET["page"]) && $_GET["page"] == $i){
      echo $i+1;
    }else{
      echo "<a class='page' href='?page=".$i."'>".($i+1)."</a>";
    }
  }
  ?>
</div>
  </div>
</body>
</html>