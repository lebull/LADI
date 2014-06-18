<?php
session_start() ; 
include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/shared.php");
checkRank(0);
?>

<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="/Travel/Utility/style/style.css" />
<link rel="stylesheet" type="text/css" href="/common/js/external/jquery_ui/custom-theme/jquery-ui-1.10.1.custom.min.css"  />

<script type="text/javascript" src="/common/js/external/jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/common/js/external/jquery_ui/js/jquery-ui-1.10.1.custom.min.js"></script>

<script type="text/javascript" src="/common/js/external/addons/ajaxform.js"></script>
<script type="text/javascript" src="/common/js/internal/autosubmit.js"></script>
<script type="text/javascript" src="/common/js/external/addons/table2CSV.js"></script>
<script type="text/javascript" src="/common/js/external/addons/sortable.js"></script>

<title>CDE - Travel</title>

<script type="text/javascript">

function getCSVData(){
 var csv_value=$('#exportTable').table2CSV({delivery:'value'});
 $("#csv_text").val(csv_value);	
}

</script>
</head>

<body>
<?php
	include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/templates/banner.php");
?>

<div class="content">
<h2>View Items</h2>

<?php
	//
	if(isset($_GET['viewAll']))
	{
		$viewAll = $_GET['viewAll'];
		
	}else{
		$viewAll = 0;
	}
	
	if($viewAll == 1)
	{
		echo("<div class='center'><a href='viewAllRequestsForm.php?viewAll=0' class='button_black'>View Open</a></div>");
	}else{
		echo("<div class='center'><a href='viewAllRequestsForm.php?viewAll=1' class='button_black'>View All</a></div>");
	}

?>

<!--Export Button-->
<div class="center">
	<form action="exportTableDownload.php" method ="post" > 
        <input type="hidden" name="csv_text" id="csv_text">
        <input type="submit" value="Export" onclick="getCSVData()" class="button_black">
    </form>
</div>

<!--View Table-->
<table class="displayTable sortable" id="exportTable">
<?php
	$searchParams = array();
	if($_SESSION[$SV_RANK] <= 0)
	{
		array_push($searchParams, new SearchParameter('fk_author', $_SESSION[$SV_USERID], '='));
	}
	
	if($viewAll == '1')
	{
		//Don't add search params.
	}else{
		array_push($searchParams, new SearchParameter('open', '1', '='));
	}
	
	$requestList = RequestManager::getAll($searchParams, "needed_date");
	$printOrder = array(
		'id',
		'timestamp',
		'location',
		'fk_author',
		'travel_date',
		'needed_date',
		'fk_setupType',
		'attendance',
		'open'
	);

	ItemManager::printTable($requestList, $printOrder);

?>
</table>
</div>
</body>
</html>