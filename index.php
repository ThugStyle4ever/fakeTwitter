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
      $sql = sprintf('INSERT INTO posts SET member_id=%d, message="%s", created=NOW()',
      mysql_real_escape_string($member['id']),
      mysql_real_escape_string($_POST['message'])
      );
      mysql_query($sql) or dirname(mysql_errno());

      header('Location: index.php');
      exit();
    }
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
        <form action="" method="post">
          <dl>
            <dt>
              <img src="member_picture/<?= $member['picture'] ?>" width="30" height="30" alt="" />
              <?= htmlspecialchars($member['name']); ?>さん、入力してください
            </dt>
            <dd>
              <textarea name="message" cols="50" rows="5"></textarea>
            </dd>
          </dl>
          <div>
            <input type="submit" value="Tweetする" />
          </div>
        </form>
      </div>
      <div id="foot">
        &copy;fakeTwitter&nbsp;2013&nbsp;all rights reserveed
      </div>
    </div>
  </body>
</html>
