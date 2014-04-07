<?php 
//Maintainable 

session_start() ; 
include($_SERVER['DOCUMENT_ROOT'] . "/Budget/Utility/shared.php");
//checkRank(3);

//==================================================
$resultArray = array();
$resultArray['success_bool'] 	= false;	//Did this action do what it intendid?
$resultArray['success_message']	= "";		//Message shown is  success_bool is 1.
$resultArray['error_message']  	= "";		//Message shown if it set.  Used for errors.
$resultArray['debug_message'] 	= "";		//Message shown if it is set.  used for debugging.
$resultArray['redirect_url'] 	= "";		//The calling page should redirect to this url if success_bool is true.
//==================================================

$resultArray['redirect_url'] = "/Budget/User/viewUsersForm.php";

$inData = $_POST;

//If any of these are null string, end the script.  For some reason, this array has to be backwards.
$requiredValues = array(
	'user',
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
	$returnArray['error_message'] = "Missing Value";
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

echo($myUser->toString());

//Send an email if it worked.
if($resultArray['success_bool'])
{
	$_SESSION[$SV_MESSAGE] = "User Added";
	
	//Send an email to the user.
	$from = "From: Coskrey@devel.distance.msstate.edu";
	$to = $inData['email'];
	$subject = "Coskrey Account Created";
	$message = 
		"An account has been created for devel.distance.msstate.edu/Budget\n" .
		"Username: " . $inData['user'] . "\nPassword: " . $rawPass . "";
	
	mail($to,$subject,$message,$from);	
}

echo(json_encode($resultArray));
?>