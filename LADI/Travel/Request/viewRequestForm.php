<?php
session_start() ; 
include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/shared.php");
checkRank(0);
?>

<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/common/js/external/jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/common/js/external/jquery_ui/js/jquery-ui-1.10.1.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="/common/js/external/jquery_ui/custom-theme/jquery-ui-1.10.1.custom.min.css"  />
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
  <h2>View Request</h2>
  
  <?php
	$editObject = new Request();
	
	if(!isset($_GET['id']) or !$editObject->getByID($_GET['id']))
	{
		die("Id Not Found");
	}
	
	$mySelf = new User();
	$mySelf->getByID($_SESSION[$SV_USERID]);
	
	if(!UserCanViewRequest($mySelf, $editObject))
	{
		die("Invalid Permissions");
	}
	
	if($editObject->getValue('open') == '1')
	{
		echo("<div class='open_div center'>Open</div>");
	}else{
		echo("<div class='closed_div center'>Closed</div>");
	}
	
	
?>


  <div class="requestDiv">

	<section>
    <h2>General Information</h2>
    <table class="displayTable">
    
    <tr>
    <td>Open/Closed</td>
    <td><?php echo($editObject->getFancyValue('open'));?></td>
    </tr>
    
    <tr>
    <td>Location</td>
    <td><?php echo($editObject->getFancyValue('location'));?></td>
    </tr>
    
    <tr>
    <td>Travel Date</td>
    <td><?php echo($editObject->getFancyValue('travel_date'));?></td>
    </tr>
    
    <tr>
    <td>Attendance</td>
    <td><?php echo($editObject->getValue('attendance'));?></td>
    </tr>
    
    <tr>
    <td>Setup Type</td>
    <td><?php echo($editObject->getFancyValue('fk_setupType'));?></td>
    </tr>
    
    <tr>
    <td>Description</td>
    <td><?php echo($editObject->getFancyValue('description'));?></td>
    </tr>
    
    <tr>
    <td>Request Author</td>
    <td><?php echo($editObject->getFancyValue('fk_author'));?></td>
    </tr>
    
    </table>
    <h2>Items Requested</h2>
    <table class="displayTable">


    <?php
	//Echo all items that we DO have.
	$itemList = ItemManager::getAll();
	
	$objectsItems = $editObject->getValue('item_requested_quantities');
	
	foreach($itemList as $itemKey=>$itemObject)
	{
		
		$itemValue = 0;
		if(isset($objectsItems[$itemObject->getValue('id')]))
		{
			$itemValue = $objectsItems[$itemObject->getValue('id')];
			echo("<tr><td>" . $itemObject->getValue('name') . "</td><td>" . $itemValue . "</td></tr>");
		}
	}
?>
    </table>
    
    <h2>Items Granted</h2>
    <table class="displayTable">


    <?php
	//Echo all items that we DO have.
	$itemList = ItemManager::getAll();
	
	$objectsItems = $editObject->getValue('item_granted_quantities');
	
	foreach($itemList as $itemKey=>$itemObject)
	{
		
		$itemValue = 0;
		if(isset($objectsItems[$itemObject->getValue('id')]))
		{
			$itemValue = $objectsItems[$itemObject->getValue('id')];
			echo("<tr><td>" . $itemObject->getValue('name') . "</td><td>" . $itemValue . "</td></tr>");
		}
	}
?>
    </table>
    </section>
    <?php
		if($_SESSION[$SV_RANK] == 1)
		{
			echo("<div class='center'><a href='editRequestForm.php?id=" . $editObject->getValue('id') . "'  class='button_black'>Edit</a></div>");
		}
	?>
    
  </div>
  
  <!-- Comments Box -->
    <div class="commentsBox">
    <?php
	$myComments = $editObject->getValue('comments');
	if(count($myComments) > 0)
	{
		foreach($myComments as $comment)
		{
			$comment_user = new User();
			$comment_user->getByID($comment['fk_user']);
			
			echo("<div>");
			echo("<strong>" . $comment_user->getValue('username') . "</strong>: " . $comment['comment'] . "<br />" . $comment['timestamp']);
			echo("</div>");
		}
	}else{
		echo("<div class='center'>(No Comments)</div>");
	}
	?>
    </div>
    <div style="text-align:center;">
    <?php
		if($_SESSION[$SV_RANK] >= 1)
		{
			?>
        <form id="autoSubmit" action="addCommentAction.php" method="POST" class="noPrint">
        	<input type="hidden" name="id" value="<?php echo $editObject->getValue('id');?>"/>
            <textarea class="comment_box_add" name='comment' rows='3' cols='60' id='description'></textarea><br />
            <input type="submit" value="Submit Comment"  class="button_black"/>
        </form>
        <?php } ?>
    </div>
  
</div>
<!--End Content-->
</body>
</html>