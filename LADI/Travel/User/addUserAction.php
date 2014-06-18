<?php 
//Maintainable 

session_start() ; 
include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/shared.php");
checkRank(1);

//==================================================
$resultArray = array();
$resultArray['success_bool'] 	= false;	//Did this action do what it intendid?
$resultArray['success_message']	= "";		//Message shown is  success_bool is 1.
$resultArray['error_message']  	= "";		//Message shown if it set.  Used for errors.
$resultArray['debug_message'] 	= "";		//Message shown if it is set.  used for debugging.
$resultArray['redirect_url'] 	= "";		//The calling page should redirect to this url if success_bool is true.
//==================================================

$resultArray['redirect_url'] = "/Travel/User/viewUsersForm.php";

$inData = $_POST;

//If any of these are null string, end the script.  For some reason, this array has to be backwards.
$requiredValues = array(
	'username',
	'email'
);



//Add LeRandomPassword
$rawPass = rand_string(5);
$inData['pass'] = crypt($rawPass, $SALT);

//Make a new user object.
$myUser = new User($inData);



//Make sure we have all of the necessary values.
if($myUser->checkValues($requiredValues) != true)
{
	$resultArray['error_message'] = "Missing Value";
	die(json_encode($resultArray));
}


//Make sure our email address is valid.
if(!filter_var($myUser->getValue('email'), FILTER_VALIDATE_EMAIL))
{
	$resultArray['error_message'] = "Invalid email format";
	die(json_encode($resultArray));
}





$resultArray['success_bool'] = $myUser->create();
//$resultArray['success_bool'] = true;


//If it worked.
if($resultArray['success_bool'])
{	
	$resultArray['success_message'] = "User Added";
	$resultArray['redirect_url'] = "/Travel/User/editUserForm.php?id=" . $myUser->getValue('id');
	
	emailAddUser($myUser, $rawPass);
		
}else{
	$resultArray['error_message'] = "Error when attempting to add user";
}

echo(json_encode($resultArray));
?>