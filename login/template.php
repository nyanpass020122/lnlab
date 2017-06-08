<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>管理パネル</title>
		<style>
		.content {
			width : 90%;
			margin : 0 auto;
		}
		.menu {
			width : 20%;
			height:500px;
			float: left;
			border-right:1px solid;
		}
		.main {
			width : 80%;
		}
		h1 {
			font-size : 20pt;
		}
		</style>
	</head>
	<body>
		<div class="content">
			<div class="menu">
				<ul>
					<li><p><a href="/">公式ページTOP</a></p></li>
					<li><p><a href="/login/">管理パネルトップ</a></p></li>
					<?php if($level >= 3) { ?>
						<li><p><a href="/login/mftp/">Web FTP</a></p></li>
					<?php }
					if ($level >= 2) { ?>
						<li><p><a href="/login/infoupd/">更新情報ページ</a></p></li>
					<?php } ?>
					<li><p><a href="/login/chat/">メンバーチャット</a></p></li>
					<li><p><a href="/login/passwd.php">パスワードの変更</a></p></li>
					<li><p><a href="/login/auth.php?mode=logout">ログアウト</a></p></li>
				</ul>
			</div>
			<div class="main">
