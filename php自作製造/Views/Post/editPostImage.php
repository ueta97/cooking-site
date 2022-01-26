<?php
session_start();
require_once(ROOT_PATH .'Controllers/PostController.php');
$post = new PostController();
$params = $post->detail();


$error = "";
$errorNumber = 0;
if(isset($_POST["id"])){

    $file = $_FILES["img"];
    $filename = basename($file["name"]);
    $tmp_path = $file["tmp_name"];
    $file_err = $file["error"];
    $filesize = $file["size"];
    $upload_dir = "/Applications/MAMP/htdocs/php自作製造/Views/Image/";
    $save_filename = date("YmdHis") . $filename;
    $save_path = $upload_dir.$save_filename;

    if($filesize > 1048574 || $file_err == 2){
      $error = "ファイルサイズは1MB未満にして下さい。";
      $errorNumber = 1;
    }
  
    $allow_ext = array("jpg", "jpeg", "png");
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    if(!in_array(strtolower($file_ext), $allow_ext)){
      $error = "画像ファイルを添付して下さい。";
      $errorNumber = 1;
    }
    

  if($errorNumber == 0){
    move_uploaded_file($tmp_path, $save_path);
    $post->updateImage($save_filename);
    header('Location: /Post/myPost.php');
    exit();
  }

}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>料理写真編集画面</title>
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>
  $(function() {
      $('.edit-btn').on('click', function() {
        if(confirm("編集しますか？")) {
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
        <h2>料理画像編集画面</h2>
      </div>
      <div class="header-right">
        <?php include("header.php"); ?>
      </div>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?=$params['post']["id"]; ?>">
      <p class="error-message"><?php echo $error; ?></p>
      <input type="hidden" name="MAX_FILE_SIZE" value="1048574" />
      <input name="img" type="file" accept="image/*" />
      <div class="editImage-btn">
        <input type="submit" class="edit-btn btn" value="編集">
      <div>
    </form>
    <!-- <a href="detailPost.php?id=<?=$params['post']["id"]; ?>">戻る</a> -->
  </div>
</body>
