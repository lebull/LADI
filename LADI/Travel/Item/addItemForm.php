<?php
session_start() ; 
include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/shared.php");
checkRank(1);
?>

<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="/common/js/external/jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/common/js/external/jquery_ui/js/jquery-ui-1.10.1.custom.min.js"></script>

<link rel="stylesheet" type="text/css" href="/Travel/Utility/js/external/jquery_ui/custom-theme/jquery-ui-1.10.1.custom.min.css"  />

<script type="text/javascript" src="/common/js/external/addons/ajaxform.js"></script>
<script type="text/javascript" src="/common/js/internal/autosubmit.js"></script>

<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:300' rel='stylesheet' type='text/css'>

<link rel="stylesheet" type="text/css" href="/Travel/Utility/style/style.css" />
<title>CDE - Travel</title>

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

<div class="content">
<h2>Add Item</h2>


<form class="editForm" id="autoSubmit" action="addItemAction.php" method="POST">

<label for="name">Name</label>
<input type="text" name="name"  id="name"/><br />

<label for="number">Quantity</label>
<input type="text" name="quantity" id="quantity"/><br />

<!--
<label>Active</label>
<span class="radioset">
    <input type="radio" name="active" id="active" value="1" checked/>
    <label for='active'>Active</label>    

    <input type="radio" name="active" id="inactive" value="0"/>
    <label for='inactive'>Inactive</label>
</span>
-->
<br />
<div class="center">
<input type="submit" class="button_black"/>
</div>
</form>

</div>
<!--End Content-->
</body>
</html>