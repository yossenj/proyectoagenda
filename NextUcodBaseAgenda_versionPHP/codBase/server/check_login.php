<?php
	include('conn.php');
	$user = $u->request("username");
	$pass = $u->request("password");
	if($user && $pass)
	{
		$u->validate($user,$pass);
	}else{
		$u->createResponse(false,"No hay data");
	}
 ?>
