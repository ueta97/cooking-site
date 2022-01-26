<?php
session_start();
require_once(ROOT_PATH .'Controllers/PostController.php');
$post = new PostController();
$params = $post->detail();

function h($s){
    return htmlspecialchars($s,ENT_QUOTES,"UTF-8");
}

$error = ["","","","",""];
$errorNumber = 0;
if(isset($_POST["title"])){

    
    if(empty($_POST['title'])) {
        $error[0] = "タイトルは必須入力です。";
        $errorNumber = 1;
    } elseif(mb_strlen($_POST['title'] > 50)) {
        $error[0] = "50文字以内でご入力ください。";
        $errorNumber = 1;
    }

    if(empty($_POST['comment'])) {
        $error[1] = "説明文は必須入力です。";
        $errorNumber = 1;
    } elseif(mb_strlen($_POST['comment'] > 250)) {
        $error[1] = "250文字以内でご入力ください。";
        $errorNumber = 1;
    }

    if(empty($_POST['item'])) {
        $error[2] = "材料は必須入力です。";
        $errorNumber = 1;
    } elseif(mb_strlen($_POST['item'] > 250)) {
        $error[2] = "250文字以内でご入力ください。";
        $errorNumber = 1;
    }

    if(empty($_POST['cooking'])) {
        $error[3] = "作り方は必須入力です。";
        $errorNumber = 1;
    } elseif(mb_strlen($_POST['cooking'] > 250)) {
        $error[3] = "250文字以内でご入力ください。";
        $errorNumber = 1;
    }

    if(empty($_POST['main_item'])) {
      $error[4] = "あなたの食材は必須入力です。";
      $errorNumber = 1;
  } elseif(mb_strlen($_POST['main_item'] > 50)) {
      $error[4] = "50文字以内でご入力ください。";
      $errorNumber = 1;
  }
    

  if($errorNumber == 0){
    $post->update();
    header('Location: /Post/myPost.php');
    exit();
  }

}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>投稿編集画面</title>
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>
  $(function() {
      $('.edited-btn').on('click', function() {
        if(confirm("編集しますか？")) {
          return true;
        } else {
          return false;
        }
      });

      $('.delete-btn').on('click', function() {
        if(confirm("削除しますか？")) {
          return true;
        } else {
          return false;
        }
      });
    });
  </script>
</head>
<body>
  <div class="all">
    <div class="header">
      <div class="header-left">
        <div class="site-title">
          <a href="index.php"><h1>ファーマーズレシピ</h1></a>
        </div>
        <h2>投稿編集画面</h2>
      </div>
      <div class="header-right">
        <?php include("header.php"); ?>
      </div>
    </div>
    <div class="post">
      <!-- <a href="detailPost.php?id=<?=$params['post']["id"]; ?>">戻る</a> -->
      <form action="" method="post">
        <div class="post-top">
          <div class="post-left">
            <img src="../Image/<?=$params["post"]["image"]; ?>">
          </div>
          <div class="post-right">
            <input type="hidden" name="id" value="<?=$params['post']["id"]; ?>">
            <p>タイトル<span>必須</span></p>
            <p class="error-message"><?php echo $error[0]; ?></p>
            <input type="text" name="title" value="<?php if(isset($_POST['title'])){echo h($_POST["title"]); }else{echo h($params['post']["title"]); } ?>">
            <p>説明文<span>必須</span></p>
            <p class="error-message"><?php echo $error[1]; ?></p>
            <textarea type="text" name="comment"><?php if(isset($_POST['comment'])){echo h($_POST["comment"]); }else{echo h($params['post']["comment"]); } ?></textarea>
            <p>材料<span>必須</span></p>
            <p class="error-message"><?php echo $error[2]; ?></p>
            <textarea type="text" name="item"><?php if(isset($_POST['item'])){echo h($_POST["item"]); }else{echo h($params['post']["item"]); } ?></textarea>
          </div>
        </div>
        <div class="post-bottom">
          <div class="cooking">
            <p>作り方<span>必須</span></p>
            <p class="error-message"><?php echo $error[3]; ?></p>
            <textarea type="text" name="cooking"><?php if(isset($_POST['cooking'])){echo h($_POST["cooking"]); }else{echo h($params['post']["cooking"]); } ?></textarea>
          </div>
          <div class="my-item">
            <div class="item-info">
              <p><?=$_SESSION["user"]["name"] ?>さんの食材<span>必須</span></p>
              <p class="error-message"><?php echo $error[4]; ?></p>
              <p><input type="text" name="main_item" value="<?php if(isset($_POST['main_item'])){echo h($_POST["main_item"]); }else{echo h($params['post']["main_item"]); } ?>"></p>
              <img src="../Image/<?=$params["post"]["main_image"]; ?>">
            </div>
            <div class="safety">
              <input type="checkbox" name="check[0]" value=1 <?php if($params["post"]['check1'] == 1){echo 'checked="checked"';}?>>農薬：栽培期間中不使用<br>
              <input type="checkbox" name="check[1]" value=1 <?php if($params["post"]['check2'] == 1){echo 'checked="checked"';}?>>節減対象農薬：栽培期間中不使用<br>
              <input type="checkbox" name="check[2]" value=1 <?php if($params["post"]['check3'] == 1){echo 'checked="checked"';}?>>遺伝子組み換えでない<br>
              <input type="checkbox" name="check[3]" value=1 <?php if($params["post"]['check4'] == 1){echo 'checked="checked"';}?>>動物性堆肥不使用
            </div>
          </div>
        </div>
        <div class="btns">
        <input type="submit" class="edited-btn btn" value="編集">
      </form>
      <form action="delete.php" method="get">
        <input type="hidden" name="id" value="<?=$params["post"]['id'] ?>">
        <input type="submit" class="delete-btn btn" value="削除">
      </form>
      </div>
    </div>
  </div>
</body>
