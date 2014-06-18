<?php
session_start() ; 
include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/shared.php");
?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" type="text/css" href="/Travel/Utility/style/style.css"  />
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300' rel='stylesheet' type='text/css'>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CDE - Travel</title>
</head>

<body>

<?php

if(isset($_SESSION[$SV_USERNAME])) 
{
	header("Location: /Travel/Request/viewAllRequestsForm.php");
}

?>

<div class="content">
<!-- Begin Content -->
    <h2>Travel Login</h2>
    <form id="login" name="login" method="POST" action="/Travel/login.php" class="editForm">

          <label>Username</label>
          <input type="text" name="loginID" id="loginID"/><br />
 
          <label>Password</label>
          <input type="password" name="pword" id="pword"/><br />
	
    	<div class="center"><input type="submit" class="button_black"/></div>
    </form>


<!-- End Content -->
</div>
</body>
</html>
