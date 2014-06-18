<?php //Maintainable
session_start() ; 
include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/shared.php");
checkRank(1);
?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" type="text/css" href="/Coskrey/Utility/style/style.css"  />
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300' rel='stylesheet' type='text/css'>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coskrey Manager</title>
</head>

<body>
<?php
include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/templates/menu.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/templates/infoBar.php");
?>

<div class="content_wrapper">
<div class="content">
<!-- Begin Content -->
<div class='button_bar'>
<a href = "../../Coskrey/User/addUserForm.php" class="button_grey">Add User</a>
</div>
<table class="eventTable">
<?php
 
$userArray = userManager::getAllUsers();


//Flag to print the table header during the first pass.
$firstPass = TRUE;

$printArray = array(
"user",
"first_name",
"last_name",
"email",
"phone_number"
);

userManager::printUserTable($userArray, $printArray);

?>
      </table>
    </div>
<!-- End Content -->
</div>
</div>
</body>
</html>