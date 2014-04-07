<?php
session_start() ; 
include($_SERVER['DOCUMENT_ROOT'] . "/Budget/Utility/shared.php");
//checkRank(3);
?>

<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/Budget/Utility/external/jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/Budget/Utility/external/jquery_ui/js/jquery-ui-1.10.1.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://devel.distance.msstate.edu/Budget/Utility/external/jquery_ui/custom-theme/jquery-ui-1.10.1.custom.min.css"  />
<script type="text/javascript" src="/Budget/Utility/external/addons/ajaxform.js"></script>
<script type="text/javascript" src="/Budget/Utility/javascript/autosubmit.js"></script>
<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="/Budget/Utility/style/style.css" />
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
	include($_SERVER['DOCUMENT_ROOT'] . "/Budget/Utility/templates/banner.php"); 
	include($_SERVER['DOCUMENT_ROOT'] . "/Budget/Utility/templates/menu.php");
?>
<div class="content">
  <!-- Begin Content -->
  <h2>View Users</h2>
  <div class='center'> <a href = "/Budget/User/addUserForm.php" class="button_black">Add User</a> </div>
  <table class='displayTable'>
    <?php


//Get a list of all users
		$userArray = UserManager::getAll();
		$sortOrder = array(
			'user', 
			'email',
			'permissions'
		);

UserManager::printTable($userArray, $sortOrder);

//Decide how the elements of each user are going to be printed

//Print the users
?>
  </table>

</div>
<!-- End Content -->
</body>
</html>