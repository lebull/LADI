<?php
//Maintainable
session_start() ; 
include($_SERVER['DOCUMENT_ROOT'] . "/Coskrey/Utility/shared.php");
checkRank(1);
?>
<!DOCTYPE HTML>
<html><head>
<title>Distance Marketing Request Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/common/js/external/jquery/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="/common/js/external/jquery_ui/js/jquery-ui-1.10.1.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="/common/js/external/jquery_ui/custom-theme/jquery-ui-1.10.1.custom.min.css"  />
<link rel="stylesheet" type="text/css" href="/Coskrey/Utility/style/style.css"  />
<script type="text/javascript">
	
	function setup1(){
		document.getElementById("permission1").defaultChecked;
		$(".radioset").buttonset();
		$("#submit").button();
	}



</script>
</head>
<body onLoad = "setup1()">
<?php
include($_SERVER['DOCUMENT_ROOT'] . "/Coskrey/Utility/banner.php");
?>
<div class="center">
<div class="inline">
<?
include($_SERVER['DOCUMENT_ROOT'] . "/Coskrey/Utility/templates/menu.php");

$user = $_GET['user'];

$myUser = new User();
$userRequestResult = $myUser->getByID($user);
echo($userRequestResult);
if($userRequestResult == FALSE) die("Invalid User ID");
$userResult = $myUser->getValues();

?>
<div class="content_admin">
  <table class = "formTable">
    <tr>
      <td><a>Username:</a></td>
      <td><?php echo($userResult['user']);?></td>
    </tr>
    <tr>
      <td><a>First Name:</a></td>
      <td><?php echo($userResult['first_name']);?></td>
    </tr>
    <tr>
      <td><a>Last Name:</a></td>
      <td><?php echo($userResult['last_name']);?></td>
    </tr>
    <tr>
      <td><a>Email:</a></td>
      <td><?php echo($userResult['email']);?></td>
    </tr>
    <tr>
      <td><a>Phone Number:</a></td>
      <td><?php echo($userResult['phone_number']);?></td>
    </tr>
    
  </table>

</div>
<div class="bottom_bar"></div>
</div>
</div>
</body>
</html>