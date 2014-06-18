<?php
/**
 *This file is responsible for sending emails for various events.
 */
$from = "From: Travel@devel.distance.msstate.edu";

if(!$TESTING)
{
	$admin_address = "agann@distance.msstate.edu";
}else{
	$admin_address = "tdarsey@distance.msstate.edu";
}

/**
 *Sends an email when a request is submitted.
 *
 *@param $inRequest The request object that is being submitted.
 */
function emailRequestSubmitted($inRequest)
{
	global $admin_address;
	global $from;

	//To the admin
	$managerEmail = $admin_address;
	$message = "A new request has been submitted.  \n" . "
	http://devel.distance.msstate.edu/Travel/Request/viewRequestForm.php?id=" . $inRequest->getValue('id') . ".";	
	$emailSubject = "New Travel Request - ID# " . $inRequest->getValue('id');
	mail($managerEmail,$emailSubject, $message, $from);

}

/**
 *Sends an email when a password is reset.
 *
 *@param $myUser The user whose password is being changed.  Sends an email to the user's email.
 *
 *@param $password The new password (should be the random sting).
 */
function emailResetPassword($myUser, $password)
{
	global $from;

	$to = $myUser->getValue('email');
	$subject = "Travel Password Reset";
	$message = "An account has been created at http://devel.distance.msstate.edu/Travel/.  Please follow this link, log in with the given username and password, and click 'change password' on the top right to set your new password.\n\n" .
	"Username: " . $myUser->getValue('username') . "\nPassword: " . $password . "";
	
	mail($to,$subject,$message, $from);	
}

/**
 *Sends and email when a user is being added.
 *
 *@param $myUser The user whose password is being changed.  Sends an email to the user's email.
 *
 *@param $password The new password (should be the random sting).
*/
function emailAddUser($myUser, $password)
{
	global $from;
	
	$to = $myUser->getValue('email');
	$subject = "Travel Account Created";
	$message = 
		"An account has been created for devel.distance.msstate.edu/Travel\n" .
		"Username: " . $myUser->getValue('username') . "\nPassword: " . $password . "";
	
	mail($to,$subject,$message, $from);
}


?>