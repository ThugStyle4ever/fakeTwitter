<?php
session_start();
require('../dbconnect.php');
require('../func.php');

	if (!isset($_SESSION['join'])) {
		header('Location: index.php');
		exit();
	}

	if(!empty($_POST)) {
		//登録処理する
		$sql = sprintf('INSERT INTO members SET name="%s", email="%s", password="%s", picture="%s", created="%s"',
			mysql_real_escape_string($_SESSION['join']['name']),
			mysql_real_escape_string($_SESSION['join']['email']),
			mysql_real_escape_string(sha1($_SESSION['join']['password'])),
			mysql_real_escape_string($_SESSION['join']['image']),date('Y-m-d H:i:s')
			);
			mysql_query($sql) or die(mysql_errno());
			unset($_SESSION['join']);

			header('Location: thanks.php');
			exit();
	}

	$name = h($_SESSION['join']['name']);
	$email = h($_SESSION['join']['email']);
	$image = h($_SESSION['join']['image']);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
		<title>会員登録</title>
	</head>
	<body id="fsz">
		<div id="wrap">
			<div id="head">
				<h1>会員登録</h1>
			</div>

			<div id="content">
				<p>次のフォームに必要事項を記入してください。</p>
				<form action="" method="post">
					<input type="hidden" name="action" value="submit" />
					<dl>
						<dt>ニックネーム</dt>
						<dd><?= $name ?></dd>
						<dt>メールアドレス</dt>
						<dd><?= $email ?></dd>
						<dt>パスワード</dt>
						<dd>【表示されません】</dd>
						<dt>写真など</dt>
						<dd>
							<img src="../member_picture/<?= $image ?>" width="100" height="100" alt="" />
						</dd>
					</dl>
				<div>
					<a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a>
					<input type="submit" value="登録する" />
				</div>
				</form>
			</div>
			<div id="foot">
				&copy;fakeTwitter&nbsp;2013&nbsp;all rights reserveed
			</div>

		</div>
	</body>
</html>
