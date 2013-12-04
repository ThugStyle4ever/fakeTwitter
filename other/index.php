<?php
	session_start();

	if (!empty($_POST)) {
	//エラー項目の確認
		if ($_POST['name'] == '') {
			$error['name'] = 'blank';
		}
		if ($_POST['email'] == '') {
			$error['email'] = 'blank';
		}
		if (strlen($_POST['password']) < 4 ){
			$error['password'] = 'length';
		}
		if ($_POST['password'] == '') {
			$error['password'] = 'blank';
		}

		if (empty($error)) {
			$_SESSION['join'] = $_POST;
			header('Location:check.php');
			exit();
		}
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
		<title>会員登録</title>
	<style type="text/css">
		body {
			font-size: 60%;
		}

	</style>
	</head>
	<body>
		<div id="wrap">
			<div id="head">
				<h1>会員登録</h1>
			</div>

			<div id="content">
				<p>次のフォームに必要事項を記入してください。</p>
				<form action="" method="post" enctype="mulutipart/form-data">
				  <dl>
					  <dt>ニックネーム<span class="required">必須</span></dt>
					  <dd><input type="text" name="name" size="35" maxlength="255" /></dd>
					  <dt>メールアドレス<span class="required">必須</span></dt>
					  <dd><input type="text" name="email" size="35" maxlength="255" /></dd>
					  <dt>パスワード<span class="required">必須</span></dt>
					  <dd><input type="password" name="password" size="10" maxlength="20" /></dd>
					  <dt>写真など</dt>
					  <dd><input type="file" name="image" size="35" /></dd>
					</dl>
				<div><input type="submit" value="入力内容を確認する" /></div>
				</form>
			</div>
			<div id="foot">
				&copy;fakeTwitter&nbsp;2013&nbsp;all rights reserveed
			</div>

		</div>
	</body>
</html>
