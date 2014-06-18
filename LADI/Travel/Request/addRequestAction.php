<?php
session_start() ; 
include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/shared.php");
checkRank(0);

//==================================================
$resultArray = array();
$resultArray['success_bool'] = false;	//Did this action do what it intendid?
$resultArray['success_message'] = "";	//Message shown is  success_bool is 1.
$resultArray['error_message']  = "";	//Message shown if it set.  Used for errors.
$resultArray['debug_message'] = "";		//Message shown if it is set.  used for debugging.
$resultArray['redirect_url'] = "";		//The calling page should redirect to this url if success_bool is true.
$resultArray['data'] = "";				//Misc data.  Used for get requests.
//==================================================

$resultArray['redirect_url'] = "/Travel/Request/viewAllRequestsForm.php";
$resultArray['success_message'] = "Item Added";

$inData = $_POST;

$addObject = new Request($inData);

$requiredValues = array(
	'travel_date',
	'attendance',
	'fk_setupType',
	'item_requested_quantities'
);

$addObject->setValue('fk_author', $_SESSION[$SV_USERID]);

if($addObject->checkValues($requiredValues) != true)
{
	$resultArray['error_message'] = "Missing Value";
	echo json_encode($resultArray);
	exit();
}

//If the request was made past a certain deadline, use this block.
/*
//If the date requested is less than 2 weeks away...
$today = new DateTime();

//Format for time intervals are here
//http://www.php.net/manual/en/dateinterval.construct.php
$cutoffDate = $today->add(new DateInterval('P14D'));

$requestDate = DateTime::createFromFormat('Y-m-d', $addObject->getValue('travel_date'));

if($requestDate < $cutoffDate) $resultArray['success_message'] = "How should we handle this?";
*/


$resultArray['success_bool'] = $addObject->create();

emailRequestSubmitted($addObject);

if($resultArray['success_bool'] == false)
{
	$resultArray['error_message'] = "Add Failed";
}

$resultArray['redirect_url'] = "/Travel/Request/viewRequestForm.php?id=" . $addObject->getValue('id');

echo json_encode($resultArray);
?>