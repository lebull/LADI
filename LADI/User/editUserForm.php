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

<?php
$myID = $_GET['id'];

$myUser = new User();
$requestResult = $myUser->getByID($myID);
if($requestResult == FALSE) die("Invalid ID");

$userResult = $myUser->getValues();
?>
  <h2>Edit User</h2>
  <form class="editForm" action = "editUserAction.php" method = "POST" class="formDiv" id="autoSubmit">
  		<label>Username:</label>
		<span><?php echo $myUser->getValue('user');?></span><br />
        <input type = "hidden" id = 'id' name = 'id' value="<?php echo($userResult['id']);?>"/>

        <label>Email:</label>
        <input type = "text" id = 'email' name = 'email' value="<?php echo($userResult['email']);?>"/><br>
        
        <label> Accounts:</label>
        
        <!-- Even if the account selection is empty, it needs to send an array.  This seems to work.-->
        <input type = "hidden" id="accounts[-1]" name="accounts[-1]" />
        
    
        <?php 
		
		$accountList = FinAccountManager::getAll();
		$myAccounts = $myUser->getAccounts();
	
		
		foreach($accountList as $eachIndex=>$eachAccount)
				{
					
					$checked = "";
					if(in_array($eachAccount->getValue('id'), $myAccounts))
					{
						$checked = "checked";
					}
					$boxname = "accounts[$eachIndex]";
					echo("<div class='checkButton'><input type='checkbox' name='$boxname' id='$boxname' value='" . $eachAccount->getValue('id') . "' $checked/>" . "<label for='$boxname'>" . $eachAccount->getValue('name') . "</label>" . "</div>\n");
				}
		?>
        
                <label>Persmissions:</label>
		<span class = "radioset">
        	<?php
				$permissions = $myUser->getValue('permissions');
				$checkedArray = array("", "", "");
				$checkedArray[(int)$permissions] = "checked";
			?>
              <input type = "radio" id = "permissions0" name = "permissions" value = "0" <?php echo($checkedArray[0]);?>/>
              <label for = "permissions0">Standard</label>
              <input type = "radio" id = "permissions1" name = "permissions" value = "1" <?php echo($checkedArray[1]);?>/>
              <label for = "permissions1">Admin</label>
              <input type = "radio" id = "permissions2" name = "permissions" value = "2" <?php echo($checkedArray[2]);?>/>
              <label for = "permissions2">Finance</label>

          </span><br>
        <label>Reset Password:</label>
		<span class = "radioset">
              <input type = "radio" id = "password1" name = "pass" value = "1"/>
              <label for = "password1">Yes</label>
              <input type = "radio" id = "password2" name = "pass" value = "0" checked/>
              <label for = "password2">No</label>
          </span><br>

        <div class="center"><input type = "submit" value = "Update" class="button_black"/></div>

    </form>
<!--End Content-->
</div>
</body>
</html>