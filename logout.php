<?php
  session_start();

  //セッション情報を削除  http://php.net/manual/ja/function.session-destroy.php
  $_SESSION = array();
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
  }
  session_destroy();

  //Cookie情報も削除  http://www.php.net/manual/ja/function.setcookie.php
  setcookie('email', '', time()-3600);
  setcookie('password', '', time()-3600);

  header('Location: login.php');
  exit();
?>