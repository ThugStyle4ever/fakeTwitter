<?php
	require('../dbconnect.php');
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
		$fileName = $_FILES['image']['name'];	//ユーザーが指定したファイル名
		if (!empty($fileName)) {
			$ext = substr($fileName,-3);	//拡張子だけ取り出す　後ろから3文字
			if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png'){	//拡張子をチェック　指定拡張でなければ$error['image']に'type'を代入
				$error['image'] = 'type';
			}
		}

		//重複アカウントのチェック
		if (empty($error)) {
			$sql = sprintf('SELECT COUNT(*) AS cnt FROM members WHERE email="%s"',
				mysql_real_escape_string($_POST['email']));
			//レコードセットを取得
			$record = mysql_query($sql) or die(mysql_error());
			//レコードセットから値を取り出す
			$table = mysql_fetch_assoc($record);

			if ($table['cnt'] > 0) {
				$error['email'] = 'duplicate';
			}
		}

		if (empty($error)) {	//どこにもerrorが無ければ
			//画像をアップロードする
			$image = date('YmdHis').$_FILES['image']['name'];	//日付を呼び出しファイル名をくっつける=$image
			// exit($image);
			move_uploaded_file($_FILES['image']['tmp_name'],'../member_picture/'.$image);	//作成したファイルをmember_pictureに移動する

			$_SESSION['join'] = $_POST;

				if(empty($_FILES['image']['name'])){
					$_SESSION['join']['image'] = 'noimage.jpg';
				}else{
					$_SESSION['join']['image'] = $image;	//$_SESSIONにファイル名(['image'])を追加する
				}
					// exit($_SESSION['join']['image']);	//NoImageの時の対処を探る。何が入っているか確認してみる⇒日付が入っている
				header('Location:check.php');
				exit();
		}
	}

	//書き直し
	if ($_GET['action'] == 'rewrite') {
		$_POST = $_SESSION['join'];
		$error['rewrite'] = true;
	}

	$name = htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8');
	$email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
	$pass = htmlspecialchars($_POST['password'],ENT_QUOTES,'UTF-8');
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
				<form action="" method="post" enctype="multipart/form-data">
					<dl>
						<dt>ニックネーム<span class="required">必須</span></dt>
						<dd>
							<input type="text" name="name" size="35" maxlength="255" value="<?= $name ?>" />

							<?php if ($error['name'] == 'blank'): ?>
							<p class="error">＊ニックネームを入力してください。</p>
							<?php endif; ?>

						</dd>

						<dt>メールアドレス<span class="required">必須</span></dt>
						<dd>
							<input type="text" name="email" size="35" maxlength="255" value="<?= $email ?>" />

							<?php if ($error['email'] == 'blank'): ?>
							<p class="error">＊メールアドレスを入力してください。</p>
							<?php endif; ?>

							<?php if ($error['email'] == 'duplicate'): ?>
							<p class="error">＊指定されたメールアドレスは既に登録されています</p>
							<?php endif; ?>

						</dd>

						<dt>パスワード<span class="required">必須</span></dt>
						<dd>
							<input type="password" name="password" size="10" maxlength="20" value="<?= $pass ?>" />

							<?php if ($error['password'] == 'blank'): ?>
							<p class="error">＊パスワードを入力してください。</p>
							<?php endif; ?>

							<?php if ($error['password'] == 'length'): ?>
							<p class="error">＊パスワードは4文字以上で入力してください。</p>
							<?php endif; ?>

						</dd>

						<dt>写真など</dt>
						<dd>
							<input type="file" name="image" size="35" />

							<?php if ($error['image'] == 'type'): ?>
							<p class="error">＊写真などは[.gif]または[.jpg]または[.png]の画像を指定してください。</p>
							<?php endif; ?>

							<?php if (!empty($error)): ?>
							<p class="error">＊指定のファイルタイプではないようです、画像を改めて指定してください。</p>
							<?php endif; ?>

						</dd>
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
