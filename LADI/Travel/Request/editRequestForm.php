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
<h2>Edit Request</h2>

<?php
	$editObject = new Request();
	
	if(!isset($_GET['id']) or !$editObject->getByID($_GET['id']))
	{
		die("Id Not Found");
	}
?>
<form class="editForm" id="autoSubmit" action="editRequestAction.php" method="POST">
<input type="hidden" name="id" value="<?php echo($editObject->getValue('id'));?>"/>
<h2>General Information</h2>

<?php
$open_default = "";
$closed_default = "";

if($editObject->getValue('open') == '1')
{
	$open_default = "checked";
}else{
	$closed_default = "checked";
}
?>

<label>Open/Closed</label>
<span class="radioset">
    <input type="radio" name="open" id="open" value="1" <?php echo $open_default;?>/>
    <label for='open'>Open</label>    

    <input type="radio" name="open" id="closed" value="0" <?php echo $closed_default;?>/>
    <label for='closed'>Closed</label>
</span>

<label for="location">Location</label>
<input type="text" name="location" id="location" value="<?php echo($editObject->getValue('location'));?>"/><br />

<label for="travel_date">Travel Date</label>
<input type="text" name="travel_date" id="travel_date" class="datepicker" value="<?php echo($editObject->getValue('travel_date'));?>"/><br />

<label for="attendance">Attendance</label>
<input type="number" name="attendance" id="attendance" value="<?php echo($editObject->getValue('attendance'));?>"/><br />




<label for="fk_setupType">Setup Type</label>
<select name="fk_setupType" required>
	<option></option>
<?php
	$setupTypeList = SetupTypeManager::getAll(array(new SearchParameter('active', '1', '=')));
	foreach($setupTypeList as $setupType)
	{
		$selected = "";
		if($setupType->getValue('id') == $editObject->getValue('fk_setupType'))
		{
			$selected = "selected";
		}
		echo("<option value='" . $setupType->getValue('id') . "' $selected>" . $setupType->getValue('name') . "</option>");
	}
?>
</select>

<label for="description">Description</label>
<textarea name="description" id="description" cols='28' rows='4' ><?php echo($editObject->getFancyValue('description'));?></textarea><br />


<h2>Items Requested</h2>


<?php
	$itemList = ItemManager::getAll();
	
	$objectsItems = $editObject->getValue('item_requested_quantities');
	
	foreach($itemList as $itemKey=>$itemObject)
	{
		$itemValue = 0;
		if(isset($objectsItems[$itemObject->getValue('id')]))
		{
			$itemValue = $objectsItems[$itemObject->getValue('id')];
		}

		echo("<label>" . $itemObject->getValue('name') . "</label>");
		echo("<input type='number' name='item_requested_quantities[" . $itemObject->getValue('id') . "]' value='" . $itemValue . "'/>");

		echo("<br />");
	}
?>

<h2>Items Granted</h2>


<?php
	$itemList = ItemManager::getAll();
	
	$objectsItems = $editObject->getValue('item_granted_quantities');
	
	foreach($itemList as $itemKey=>$itemObject)
	{
		$itemValue = 0;
		if(isset($objectsItems[$itemObject->getValue('id')]))
		{
			$itemValue = $objectsItems[$itemObject->getValue('id')];
		}

		echo("<label>" . $itemObject->getValue('name') . "</label>");
		echo("<input style='min-width:50px;' type='number' name='item_granted_quantities[" . $itemObject->getValue('id') . "]' value='" . $itemValue . "'/>");
		echo("<span style=\"margin-left:25px; text-align:right;\">(" . $itemObject->getValue('quantity') . " left )</span>");
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