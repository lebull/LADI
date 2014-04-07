<?php
session_start() ; 
include($_SERVER['DOCUMENT_ROOT'] . "/Budget/Utility/shared.php");
checkRank(3);
?>

<!DOCTYPE HTML>
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
	//initAutoSubmit("#autoSubmit");
}
</script>
</head>
<body onLoad="setup1()">
<?php 
	include($_SERVER['DOCUMENT_ROOT'] . "/Budget/Utility/templates/banner.php"); 
	include($_SERVER['DOCUMENT_ROOT'] . "/Budget/Utility/templates/menu.php");
?>
<div class="content_wrapper">
  <div class="content"> 
    <!-- Begin Content -->
    <h2>Add User</h2>
    <form class="editForm" id="auto_submit" action = "addUserAction.php" method = "POST">
      
        
          <label>Username</label>
          <input type = "text" id = 'user' name = 'user' required/><br>
          <label>First Name</label>
          <input type = "text" id = 'first_name' name = 'first_name'/><br>
       
          <label>Last Name</label>
          <input type = "text" id = 'last_name' name = 'last_name'/><br>

          <label>Email</label>
          <input type = "text" id = 'email' name = 'email' required/><br>

          <div class="center"><input type = "submit" value = "Submit" class="button_black"/></div>
    </form>
    <!--End Content-->
  </div>
</div>
</body>
</html>