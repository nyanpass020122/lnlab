<?php
$pageLevel = 2;
include_once("../load.php");
include_once("../template.php");
?>
<h1>最新情報の書き込み</h1>
<p>※書き込みと同時に購読登録者のWebブラウザへ一斉に通知が行われます。</p>
<form action="update.php" method="post">
<p>内容：<input type="text" name="content"></p>
<input type="submit">
</form>
