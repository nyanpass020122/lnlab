<?php
$pageLevel = 0;
include_once("load.php");
include_once("template.php");
?>
				<h1><?php echo $name; ?>さん、ようこそ！</h1>
				<p>あなたの権限レベルは<?php echo $level; ?>です。</p>
				<p>（参考：管理者 3・更新通知ユーザー 2・一般 1）
				<p>このページでは、各ページへのリンクをまとめてあります。</p>
				<?php if($level > 2) { ?>
				<hr>
				<p>FTP設定情報</p>
				<p>HOST:non.luna-labo.net</p>
				<p>ID:geppei-lab</p>
				<p>PW:LnLabPasswd2783</p>
				<p>ポート:43044</p>
				<?php } ?>
			</div>
		</div>
	</body>
