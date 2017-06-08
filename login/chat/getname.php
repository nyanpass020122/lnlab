<?php
$obj = json_decode(file_get_contents('/opt/app-root/src/users.json'));
$id = $_SESSION['authid'];
$username = $obj->$id->name;
