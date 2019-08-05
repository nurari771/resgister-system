<?php
	session_start();	
	include_once("config.php");
	$strSQL = "SELECT * FROM test1 WHERE username = '".mysqli_real_escape_string($mysqli,$_POST['username'])."' 
	and password = '".mysqli_real_escape_string($mysqli,$_POST['password'])."'";
	
	$objQuery = mysqli_query($mysqli,$strSQL); 
	$objResult = mysqli_fetch_array($objQuery); // เอาผลลัพท์มาใส่ใน $objResult

	//เก็บ SESSION
	$_SESSION["username"] = $objResult["username"]; 
	$_SESSION["password"] = $objResult["password"]; 
		
	if(!$objResult) {
  			echo 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
	}else {
	 	echo 'Login Seccce';
	 }

	mysqli_close($mysqli);
?>
