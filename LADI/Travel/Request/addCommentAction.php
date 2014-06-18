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
//==================================================

$inData = $_POST;

$editObject = new Request($inData);

$requiredValues = array(
	'id',
	'comment'
);

if($editObject->checkValues($requiredValues) != true)
{
	$resultArray['error_message'] = "Missing Value";
	die(json_encode($resultArray));
}

//We only want to deal with id and comment.
foreach($editObject->getValues() as $valueKey=>$value)
{
	if(!in_array($valueKey, $requiredValues))
	{
		$editObject->deleteValue($valueKey);
	}
}

$resultArray['success_bool'] = $editObject->update();
if($resultArray['success_bool'] == true)
{
	$resultArray['redirect_url'] = "/Travel/Request/viewRequestForm.php?id=" . $editObject->getValue('id');
}

echo json_encode($resultArray);
?>