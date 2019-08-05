<?PHP
	session_start();
	require_once("dbconnect.php");
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <title>Register</title>
    <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
    <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
    <link rel="STYLESHEET" type="text/css" href="style/pwdwidget.css" />
    <script src="scripts/pwdwidget.js" type="text/javascript"></script> 
    
    <script type='text/javascript'>
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
</head>

<body>
<div id='fg_membersite'>

<?php
if(isset($_POST['signup'])) {
	// code for check server side validation
	if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
		$msg="<span style='color:red'>The Validation code does not match!</span>";// Captcha verification is incorrect.		
	}else{// Captcha verification is Correct. Final Code Execute here!		

	$name = $mysqli->real_escape_string($_POST['name']);
	$email = $mysqli->real_escape_string($_POST['email']);
	$username = $mysqli->real_escape_string($_POST['username']);
	$password = $mysqli->real_escape_string($_POST['password']);
//Check MEMBERNo for dupplicate 		
	$check = "SELECT * FROM test1  WHERE  username = '$username'";

	$result = mysqli_query($mysqli,$check) or die(mysql_error());
		
	$row= mysqli_fetch_array($result,MYSQLI_ASSOC); //แสดงค่า $row
	if(!$row ){    //check $row  = null
		$query = "INSERT INTO test1(name,email,password,username) VALUES('$name','$email','$password','$username')";
	
	if($mysqli->query($query)) { // ?> 
		<div class="alert alert-success" role="alert">สมัครสมาชิคสำเร็จ</div>
		<?php } else { ?>
		<div class="alert alert-danger" role="alert">สมัครสมาชิคไม่สำเร็จ โปรดลองใหม่</div>
		<?php
	}
	}else { 
	 echo "<script>";
			 echo "alert('username นี้มีการลงทะเบียนไปแล้วครับ !!!');";
			 echo "window.location='regis.php';";
          	 echo "</script>";
	}
	
    	}
}?>

<form id='register' method='post' accept-charset='UTF-8'>
<fieldset >
	<legend>Register</legend>
    <input type='hidden' name='submitted' id='submitted' value='1'/>

	<div class='short_explanation'>* required fields</div>
    <?php if(isset($msg)){?>

      <td colspan="2" align="center" valign="top"><?php echo $msg;?>
    <?php } ?>

	<div class='container'>
     <label for='name' >Your Full Name*: </label><br/>
		<input type='text' class="form-control" name="name"  maxlength="50" />
	</div>

    <div class='container'>
    <label for='email' >Email Address*:</label><br/>
    <input type='text' class="form-control"   name='email' id='email'  maxlength="50" /><br/>
    <span id='register_email_errorloc' class='error'></span>
</div>

<div class='container'>
    <label for='username' >UserName*:</label><br/>
    <input type='text' class="form-control" name='username' id='username'  maxlength="50" /><br/>
    <span id='register_username_errorloc' class='error'></span>
</div>

    <div class='container' style='height:80px;'>
    <label for='password' >Password*:</label><br/>
    <div class='pwdwidgetdiv' id='thepwddiv' ></div>
    <noscript>
    <input type='password' v name='password' id='password' maxlength="50" />
    </noscript>    
    <div id='register_password_errorloc' class='error' style='clear:both'></div>
</div>

<div class='container'>
    <label for='email' >Captcha*:</label><br/>
    <img src="captcha.php?rand=<?php echo rand();?>" id='captchaimg'>
    <a href='javascript: refreshCaptcha();'><img src="style/refresh.png" width="24" height="22"></a>
    <input id="captcha_code" name="captcha_code" type="text"><br/>
   
</div>



<div class='container'>
    <input type='submit' name="signup" value='Submit' />
</div>

    </fieldset>
</form>

<script type='text/javascript'>
// <![CDATA[
    var pwdwidget = new PasswordWidget('thepwddiv','password');
    pwdwidget.MakePWDWidget();
    
    var frmvalidator  = new Validator("register");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("name","req","Please provide your name");

    frmvalidator.addValidation("email","req","Please provide your email address");

    frmvalidator.addValidation("email","email","Please provide a valid email address");

    frmvalidator.addValidation("username","req","Please provide a username");
    
    frmvalidator.addValidation("password","req","Please provide a password");
</script>
</div>
</body>
</html>