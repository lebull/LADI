<?php
session_start() ; 
include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/shared.php");
checkRank(0);
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
	$(".button").button("option");
	$(".radioset").buttonset();
	$(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});
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
<h2>Submit Request</h2>

<div class="alert">
<p>
Travel bag request should be submitted no later than a week from when you will actually need the bag. If for some reason you should miss the deadline please explain in the description. 
</p>
</div>

<form class="editForm" id="autoSubmit" action="addRequestAction.php" method="POST">

<h2>General Information</h2>

<label for="location">Location</label>
<input type="text" name="location" id="location" required/><br />

<label for="travel_date">Travel Date</label>
<input type="text" name="travel_date" id="travel_date" class="datepicker" required/><br />

<label for="needed_date">Needed Date</label>
<input type="text" name="needed_date" id="needed_date" class="datepicker" required/><br />

<label for="attendance">Attendance</label>
<input type="number" name="attendance" id="attendance" required/><br />




<label for="fk_setupType">Setup Type</label>
<select name="fk_setupType" required>
	<option></option>
<?php
	$setupTypeList = SetupTypeManager::getAll(array(new SearchParameter('active', '1', '=')));
	foreach($setupTypeList as $setupType)
	{
		echo("<option value='" . $setupType->getValue('id') . "'>" . $setupType->getValue('name') . "</option>");
	}
?>
</select>
<!--<input type="number" name="fk_setupType" id="fk_setupType"/><br />-->

<label for="description">Description</label>
<textarea name="description" id="description" cols='28' rows='4'></textarea><br />


<h2>Items Requested</h2>


<?php
	$itemParams = array(new SearchParameter('active', '1', '='));
	$itemList = ItemManager::getAll($itemParams);
	foreach($itemList as $item)
	{

		echo("<label>" . $item->getValue('name') . "</label>");
		echo("<input type='number' name='item_requested_quantities[" . $item->getValue('id') . "]' value='0'/>");

		echo("<br />");
	}
?>

<div class="center">
<input type="submit" class="button_black"/>
</div>
</form>

</div>
<!--End Content-->
</body>
</html>