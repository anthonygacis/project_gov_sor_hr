<?php
	include "connection/connection.php";
	session_start();

	if(isset($_SESSION["username"])){
		$gmt_last_access = date("Y-m-d H:i:s");
		// update last access
		$u = DB::run("UPDATE user_accounts SET gmt_last_access = ? WHERE uid = ?", [$gmt_last_access, $_SESSION["uid"]]);

		session_destroy();
	}

	header("Location: login.php");
?>
