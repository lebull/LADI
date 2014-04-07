<?php
//Maintainable.
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

$resultArray['success_message'] = "User Updated";
//$resultArray['redirect_url'] = "http://devel.distance.msstate.edu/Budget/User/viewAllUsersForm.php";
$inData = $_POST;

//In this case, we are just resetting the password if 'pass' from post is set to 1.
//We do not handle actually setting passwords here.
if(isset($inData['pass']))
{
	if($inData['pass'] == '1')
	{
		$pass = rand_string(5);
		$inData['pass'] = crypt($pass , $SALT);
	}else{
		unset($inData['pass']);
	}
}


$myUser = new User($inData);

//Make sure our email address is valid.
if(!filter_var($myUser->getValue('email'), FILTER_VALIDATE_EMAIL))
{
	$resultArray['error_message'] = "Invalid email format";
	die(json_encode($resultArray));
}

$resultArray['success_bool'] = $myUser->update();
$myUser->getByID($myUser->getValue('id'));

if($resultArray['success_bool']){
	//Send an email to the user if the password is changing.
	
	if(isset($inData['pass']))
	{	
			$from = "From: Coskrey@devel.distance.msstate.edu";
			$to = $inData['email'];
			$subject = "Coskrey Password Reset";
			$message = 
			"Username: " . $myUser->getValue('user') . "\nPassword: " . $pass . "";
			
			mail($to,$subject,$message,$from);
	}
}else{
	$resultArray['error_message'] = "Update Failed";
}


echo(json_encode($resultArray));

?>