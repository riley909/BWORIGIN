<?php
	require '/var/www/dbInfo.php';
	session_start();
	header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩

	// DB주소, DB계정아이디, DB계정비밀번호, DB이름
	$db = new mysqli($dbHost, $dbUser, $dbPwd, $dbName); 
	$db->set_charset("utf8");

	function queryResult($sql)
	{
		global $db;
		return $db->query($sql);
	}
?>