<?php
  session_start();
  require('dbconnect.php');

  if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {  //ログインして1時間以内かどうか
    //ログインしている
    $_SESSION['time'] = time();

    $sql = sprintf('SELECT * FROM members WHERE id="%d"',  //sprintf ref.152：文字列を書式化する
      mysql_real_escape_string($_SESSION['id'])  //ref.379：MySQLのSQL文用に文字列をエスケープする
    );
    $record = mysql_query($sql) or die(mysql_error());
    $member = mysql_fetch_assoc($record);
  }else{
    //ログインしていない
    header('Location: login.php');
    exit();
  }

  //投稿を記録する
  if (!empty($_POST)) {
    if ($_POST['message'] != '') {
      $sql = sprintf('INSERT INTO posts SET member_id=%d, message="%s", reply_post_id=%d, created=NOW()',
      mysql_real_escape_string($member['id']),
      mysql_real_escape_string($_POST['message']),
      mysql_real_escape_string($_POST['reply_post_id'])
      );
      mysql_query($sql) or die(mysql_error());

      header('Location: index.php');
      exit();
    }
  }

  //投稿を取得する
  // $sql = sprintf('SELECT m.name, m.picture, p. * FROM members m, posts p WHERE m.id=p.member_id ORDER BY p.created DESC'); sprintfは意味が無い
  $sql = 'SELECT m.name, m.picture, p. * FROM members m, posts p WHERE m.id=p.member_id ORDER BY p.created DESC';
  $posts = mysql_query($sql) or die(mysql_error()
    );

  //返信[Re]が押された場合
  if (isset($_GET['res'])) {
    $sql = sprintf('SELECT m.name, m.picture, p. * FROM members m, posts p WHERE m.id=p.member_id AND p.id=%d ORDER BY p.created DESC',
      mysql_real_escape_string($_GET['res'])
      );
      $record = mysql_query($sql) or die(mysql_error());
      $table = mysql_fetch_assoc($record);
      $message = '@'. $table['name']. '&nbsp;&nbsp;' . $table['message'];
      $res = htmlspecialchars($_GET['res'], ENT_QUOTES, 'UTF-8');
  }
  //本文内のURLリンクを設定
  function makeLink($value){
    return mb_ereg_replace("(https?)(://[[:alnum:]\+\$\;¥?\.%,!#~*/:@&=_-]+)", '<a href="\1\2">\1\2</a>', $value);
  }
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
        <div style="text-align: right"><a href="logout.php">ログアウト</a></div>
        <form action="" method="post">
          <dl>
            <dt>
              <img src="member_picture/<?= $member['picture'] ?>" width="35" height="35" alt="" />
              <?= htmlspecialchars($member['name']); ?>さん、入力してください
            </dt>
            <dd>
              <textarea name="message" cols="50" rows="5"><?= $message ?></textarea>
              <input type="hidden" name="reply_post_id" value="<?= $res ?>" />
            </dd>
          </dl>
          <div>
            <input type="submit" value="Tweetする" />
          </div>
        </form>

        <?php
        while ($post = mysql_fetch_assoc($posts)):

        $picture = htmlspecialchars($post['picture'], ENT_QUOTES, 'UTF-8');
        $name = htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8');
        $messa = str_replace("\n", "<br />", $post['message']);
        $created = htmlspecialchars($post['created'], ENT_QUOTES, 'UTF-8');
        $id = htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8');
        $rep = htmlspecialchars($post['reply_post_id'], ENT_QUOTES, 'UTF-8');
        ?>

        <div class="msg">
          <hr />
          <img src="member_picture/<?= $picture ?>" height="48" width="48" alt="<?= $name ?>" />
          <p><?= makeLink($messa) ?>
            <span class="name" id="tname">(<?= $name ?>)</span>
            [<a href="index.php?res=<?= $id ?>">Re</a>]
          </p>
          <p class="day" id="day"><a href="view.php?id=<?= $id ?><?= $created ?>"><?= $created ?></a>

          <?php
          if ($post['reply_post_id'] > 0):
          ?>
          <a href="view.php?id=<?= $rep ?>">返信元のメッセージ</a>
          <?php
          endif;
          ?>

          <?php
            if ($_SESSION['id'] == $post['member_id']):
          ?>
            [<a href="delete.php?id=<?= $id ?>" style="color: #f33;">Delete</a>]
          <?php
          endif;
          ?>

          </p>
        </div>
        <?php
        endwhile;
        ?>
      </div>
      <div id="foot">
        &copy;fakeTwitter&nbsp;2013&nbsp;all rights reserveed
      </div>
    </div>
  </body>
</html>
