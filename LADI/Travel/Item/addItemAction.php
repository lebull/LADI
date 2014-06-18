<?php
session_start() ; 
include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/shared.php");
checkRank(1);

//==================================================
$resultArray = array();
$resultArray['success_bool'] = false;	//Did this action do what it intendid?
$resultArray['success_message'] = "";	//Message shown is  success_bool is 1.
$resultArray['error_message']  = "";	//Message shown if it set.  Used for errors.
$resultArray['debug_message'] = "";		//Message shown if it is set.  used for debugging.
$resultArray['redirect_url'] = "";		//The calling page should redirect to this url if success_bool is true.
$resultArray['data'] = "";				//Misc data.  Used for get requests.
//==================================================

$resultArray['redirect_url'] = "/Travel/Item/viewAllItemsForm.php";

$inData = $_POST;

$editObject = new Item($inData);

$requiredValues = array(
	'name',
	'quantity'
);

if($editObject->checkValues($requiredValues) != true)
{
	$resultArray['error_message'] = "Missing Value";
	echo json_encode($resultArray);
	exit();
}

$resultArray['success_bool'] = $editObject->create();

$resultArray['success_message'] = "Item Added";

if($resultArray['success_bool'] == false)
{
	$resultArray['error_message'] = "Add Failed";
}

echo json_encode($resultArray);
?>