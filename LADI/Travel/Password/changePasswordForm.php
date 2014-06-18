<?php
session_start() ; 
include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/shared.php");
checkRank(0);
?>

<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="/common/js/external/jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/common/js/external/jquery_ui/js/jquery-ui-1.10.1.custom.min.js"></script>

<link rel="stylesheet" type="text/css" href="/Travel/Utility/js/external/jquery_ui/custom-theme/jquery-ui-1.10.1.custom.min.css"  />

<script type="text/javascript" src="/common/js/external/addons/ajaxform.js"></script>
<script type="text/javascript" src="/common/js/internal/autosubmit.js"></script>

<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:300' rel='stylesheet' type='text/css'>

<link rel="stylesheet" type="text/css" href="/Travel/Utility/style/style.css" />
<title>CDE - Budget</title>

<script type="text/javascript">
function onSetup()
{
	$(".radioset").buttonset();
	initAutoSubmit("#autoSubmit");
}
</script>
</head>
<body onLoad="onSetup()">  
<?php 
	include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/templates/banner.php"); 
	include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/templates/menu.php");
?>

<!--Begin Content-->
<div class="content">
<h2>Change Passwords</h2>

<form class="editForm" id="autoSubmit" method="POST" action="changePasswordAction.php">

			<label>New Password</label>
			<input type = 'password' name = 'new'><br>


			<label>Confirm Password</label>
			<input type = 'password' name = 'confirm'><br>


			<div class="center"><input type="submit" class="button_black"/></div>

</form>
<p class="center">Passwords must be 8 to 30 characters long and contain at least one special character or number.</p>
</div>
</body>
</html>