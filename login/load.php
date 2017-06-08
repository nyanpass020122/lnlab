<?php

session_start();

$id = $_SESSION['authid'];
$pw = $_SESSION['authpw'];

if(empty($id) or empty($pw)) {
	exit;
}

$json = file_get_contents('/opt/app-root/src/login/users.json');
$user = json_decode($json);

$truePw = $user->$id->passwd;

function deny() {
	http_response_code(403);
	exit;
}

if($pw == $truePw) {
	$level = $user->$id->level;
	$name = $user->$id->name;
	if($pageLevel > $level) {
		deny();
	}
} else {
	deny();
}

