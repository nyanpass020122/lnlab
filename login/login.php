<?php
if(empty($_GET['mode'])) {
	$txt = "";
} elseif($_GET['mode'] == logout) {
	$txt = "ログアウトしました。";
} elseif($_GET['mode'] == error) {
	$txt = "認証に失敗しました";
} elseif($_GET['mode'] == added) {
	$txt = "登録されました。";
} elseif($_GET['mode'] == changed) {
	$txt = "パスワードは正常に変更されました。";
}
?>

<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>月餅研究所認証画面</title>
	<style>
		div {
			width : 500px;
			margin : 0 auto;
			border-radius : 10px;
			background-color : #f0f8ff;
			height : 400px;
		}
		form {
			width : 400px;
			margin : 0 auto;
		}
		a {
			width : 50px;
			float : left;
			text-align : center;
			line-height : 40px;
		}
		input {
			width : 346px;
			height : 40px;
			border-radius : 5px;
			border : 1px #777 solid;
		}

	</style>
</head>
<body>

	<div>
		<h1>認証画面</h1>
		<p><?php echo $txt; ?></p>
		<form action="auth.php" method="post">
			<label for="id"><a>ID</a></label><input type="text" name="id" id="id"><br>
			<label for="pw"><a>PW</a></label><input type="password" name="pw" id="pw"><br>
			<input type="submit" id="submit" value="ログイン">
		</form>
	</div>
</body>
</html>
