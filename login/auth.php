<?php

$mode = $_GET['mode'];
if($mode == "logout") {
	session_start();
	session_unset();
	header('Location: https://luna-labo.net/login/login.php?mode=logout');
	exit;
} elseif($mode == "reg") {
	$regkey = "唐揚弁当";
	if($_POST['key'] == $regkey) {
		$id = $_POST['id'];
		$pw = $_POST['pw'];
		$name =$_POST['name'];

		$base = file_get_contents('add.php');
		$ndata = str_replace("]];",  "],\n\"".$id."\"=>[\n\"level\"=>\"1\",\n\"passwd\"=>\"".$pw."\",\n\"name\"=>\"".$name."\"\n]];"  ,$base);
		file_put_contents("add.php",$ndata);
		exec("php /opt/app-root/src/login/add.php");
		header('Location: https://luna-labo.net/login/login.php?mode=added');
	} else {
		header('Location: https://luna-labo.net/login/login.php?mode=error');
	}
	exit;
} elseif($mode == "passwd") {
	$pageLevel = 1;
	include_once('load.php');
	$oldPwTrue = $_SESSION['authpw'];
	$oldPw= $_POST['old'];
	$newPw= $_POST['new'];

	$search = "],\n\"".$id."\"=>[\n\"level\"=>\"".$level."\",\n\"passwd\"=>\"".$oldPw."\",\n\"name\"=>\"".$name."\"\n]";
	$replace = "],\n\"".$id."\"=>[\n\"level\"=>\"".$level."\",\n\"passwd\"=>\"".$newPw."\",\n\"name\"=>\"".$name."\"\n]";

	if($oldPw == $oldPwTrue) {
		$data = file_get_contents('add.php');
		$data = str_replace($search,$replace,$data);

		file_put_contents('add.php',$data);
		exec('php add.php');
		session_unset();
		header('Location: https://luna-labo.net/login/login.php?mode=changed');
	} else {
		header('Location: https://luna-labo.net/login/passwd.php?mode=error');
	}
	exit;
}

session_start();
$id = $_POST['id'];
$pw = $_POST['pw'];

if(empty($id) or empty($pw)) {
	session_unset();
	header('Location: https://luna-labo.net/login/login.php?mode=error');
}


$json = file_get_contents('users.json');
$users = json_decode($json);

$truePw = $users->$id->passwd;


if($pw == $truePw) {
	$_SESSION['authid'] = $id;
	$_SESSION['authpw'] = $pw;
	header('Location: https://luna-labo.net/login/');
} else {
	session_unset();
	header('Location: https://luna-labo.net/login/login.php?mode=error');
}
