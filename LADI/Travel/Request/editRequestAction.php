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
$resultArray['success_message'] = "Item Updated";

$inData = $_POST;

$editObject = new Request($inData);

$requiredValues = array(
	'id',
	'travel_date',
	'attendance',
	'fk_setupType',
	'item_requested_quantities',
	'item_granted_quantities'
);

$editObject->setValue('fk_author', $_SESSION[$SV_USERID]);

if($editObject->checkValues($requiredValues) != true)
{
	$resultArray['error_message'] = "Missing Value";
	echo json_encode($resultArray);
	exit();
}


//Handle the updating of item quantities remaining.
$oldObject = new Request();
$oldObject->getByID($editObject->getValue('id'));

$updatedItemsDifference = array();

if($oldObject->checkValues(array('item_granted_quantities')))
{
	$oldGrantedItems = $oldObject->getValue('item_granted_quantities');
	$newGrantedItems = $editObject->getValue('item_granted_quantities');
	
	foreach($newGrantedItems as $newItemKey=>$newItemValue)
	{
		if(isset($oldGrantedItems[$newItemKey]))
		{
			$updatedItemsDifference[$newItemKey] = $newItemValue - $oldGrantedItems[$newItemKey];
		}else{
			$updatedItemsDifference[$newItemKey] = $newItemValue;
		}
	}
}else{
	$updatedItemsDifference = $newGrantedItems;
}


foreach($updatedItemsDifference as $updateQuantityKey=>$updateQuantityValue)
{
	$editItem = new Item();
	$editItem->getByID($updateQuantityKey);
	$editItem->setValue('quantity', $editItem->getValue('quantity') - $updateQuantityValue);
	$editItem->update();
	
	if($editItem->getValue('quantity') < 0)
	{
		$resultArray['success_message'] = sprintf("NOTICE: The available number of %s appears to be zero or fewer.", $editItem->getValue('name'));
	}
}


$resultArray['success_bool'] = $editObject->update();


if($resultArray['success_bool'] == false)
{
	$resultArray['error_message'] = "Add Failed";
}

$resultArray['redirect_url'] = "/Travel/Request/viewRequestForm.php?id=" . $editObject->getValue('id');

echo json_encode($resultArray);
?>