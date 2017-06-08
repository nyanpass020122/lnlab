<?php
$pageLevel = 1;
include_once('load.php');
include_once('template.php');

if(empty($_GET['mode'])) {
	$txt = "";
} elseif($_GET['mode'] == "error") {
	$txt = "認証に失敗しました";
}
?>
<p><?php echo $txt; ?></p>
<form action="auth.php?mode=passwd" method="POST">
	<label for="old"><p>元のパスワード</p></label>
	<input type="password" name="old" id="name">
	<label for="new"><p>新規パスワード</p></label>
	<input type="password" name="new" id="new">
	<input type="submit" value="変更">
</form></div></div></body></html>
