<?php
  session_start();
  require('dbconnect.php');
  require('func.php');

  if (empty($_GET['id'])) {
      header('Location: index.php');
      exit();
    }

  //投稿を取得する
  $sql = sprintf('SELECT m.name, m.picture, p. * FROM members m, posts p WHERE m.id=p.member_id AND p.id=%d ORDER BY p.created DESC',
  mysql_real_escape_string($_GET['id'])
  );
  $posts = mysql_query($sql) or die(mysql_error());
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <title>fakeTwitter</title>
  </head>
  <body id="fsz">
    <div id="wrap">
      <div id="head">
        <h1>fakeTwitter</h1>
      </div>

      <div id="content">
        <p>&laquo;<a href="index.php">一覧に戻る</a></p>

        <?php
        if ($post = mysql_fetch_assoc($posts)):

        $picture = h($post['picture']);
        $name = h($post['name']);
        $messa = str_replace("\n", "<br />", $post['message']);
        $created = h($post['created']);
        $id = h($post['id']);
        ?>

        <div class="msg">
          <hr />
          <img src="member_picture/<?= $picture ?>" height="55" width="55" alt="<?= $name ?>" />
          <p><?= $messa ?>
            <span class="name" id="tname">(<?= $name ?>)</span>
          </p>
          <p class="day" id="day"><?= $created ?></p>
        </div>

        <?php
        else:
        ?>
          <p>そのTweetは削除されたか、URLが間違っています</p>
        <?php
        endif;
        ?>

      </div>
      <div id="foot">
        &copy;fakeTwitter&nbsp;2013&nbsp;all rights reserveed
      </div>
    </div>
  </body>
</html>
