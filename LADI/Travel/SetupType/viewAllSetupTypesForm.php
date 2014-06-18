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
<link rel="stylesheet" type="text/css" href="/common/js/external/jquery_ui/custom-theme/jquery-ui-1.10.1.custom.min.css"  />
<script type="text/javascript" src="/common/js/external/addons/ajaxform.js"></script>
<script type="text/javascript" src="/common/js/internal/autosubmit.js"></script>
<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="/Travel/Utility/style/style.css" />
<title>CDE - Travel</title>
</head>

<body>
<?php
	include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/templates/banner.php");
?>

<div class="content">
<h2>View SetupTypes</h2>

<div class="center"><a href="/Travel/SetupType/addSetupTypeForm.php" class="button_black">Add SetupType</a></div>
<table class="displayTable">
<?php
	$mySetupTypeList = SetupTypeManager::getAll();
	$printOrder = array(
		'id',
		'name',
		'active'
	);

	SetupTypeManager::printTable($mySetupTypeList, $printOrder);

?>
</table>
</div>
</body>
</html>