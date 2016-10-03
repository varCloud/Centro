<?php
session_start();
$data["login_status"]='error';
	if(isset($_SESSION['usuario']))
	{
		unset($_SESSION['usuario']);
		$data["login_status"] ="success";
		session_destroy();
	}

    if(isset($_SESSION['Admin']))
	{
		unset($_SESSION['Admin']);
		$data["login_status"] ="success";
		session_destroy();
	}
	echo json_encode($data);
?>

