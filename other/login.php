<?php
require('dbconnect.php');
session_start();

if (!empty($_POST)) {
  //ログインの処理
  if ($_POST['email'] != '' && $_POST['password'] != '') {
    $sql = sprintf('SELECT * FROM members WHERE email="%s" AND password="%s"',
      mysql_real_escape_string($_POST['email']),
      mysql_real_escape_string(sha1($_POST['password']))
    );
    $record = mysql_query($sql) or die(mysql_errno());
    if ($table = mysql_fetch_assoc($record)) {
    //ログイン成功
      $_SESSION['id'] = $table['id'];
      $_SESSION['time'] = time();
      header('Location: index.php');
      exit();
    }else{
      $error['login'] = 'failed';
    }
  }else{
    $error['login'] = 'blank';
    }
  }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <title>ログイン</title>
  </head>
  <body id="fsz">
    <div id="wrap">
      <div id="head">
        <h1>ログイン</h1>
      </div>
      <div id="content">
        <div id="lead">
          <p>メールアドレスとパスワードを入力しログインしてください。</p>
          <p>入会手続きがまだの方はこちらからどうぞ。</p>
          <p>&raquo;<a href="join/">入会手続きする</a></p>
        </div>
        <form action="" method="post">
          <dl>
            <dt>メールアドレス</dt>
            <dd>
              <input type="text" name="name" size="35" maxlength="255" value="<?= htmlspecialchars($_POST['email']); ?>" />

              <?php if($error['login']) == 'blank': ?>
              <p class="error">＊メールアドレスとパスワードを入力してください</p>
              <?php endif; ?>

              <?php if($error['login']) == 'failed': ?>
              <p class="error">＊ログインに失敗しました。正しく入力してください。</p>
              <?php endif; ?>

            </dd>
            <dt>パスワード</dt>
            <dd>
              <input type="password" name="password" size="35" maxlength="255" value="<?= htmlspecialchars($_POST['password']) ?>" />
            </dd>
            <dt>ログイン情報の記録</dt>
            <dd>
              <input id="save" type="checkbox" name="save" value="on" />
              <label for="save">次回からは自動的にログインする</label>
            </dd>
          </dl>
        <div><input type="submit" value="ログインする" /></div>
        </form>
      </div>
      <div id="foot">
        &copy;fakeTwitter&nbsp;2013&nbsp;all rights reserveed
      </div>

    </div>
  </body>
</html>