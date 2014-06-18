<?php session_start() ; 
	include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/shared.php");
	checkRank(0);
	
	//==================================================
	$resultArray = array();
	$resultArray['success_bool'] 	= false;	//Did this action do what it intendid?
	$resultArray['success_message']	= "";		//Message shown is  success_bool is 1.
	$resultArray['error_message']  	= "";		//Message shown if it set.  Used for errors.
	$resultArray['debug_message'] 	= "";		//Message shown if it is set.  used for debugging.
	$resultArray['redirect_url'] 	= "";		//The calling page should redirect to this url if success_bool is true.
	//==================================================

	$resultArray['redirect_url'] = "";		//The calling page should redirect to this url if success_bool is true.

	if(isset($_POST['new']))
	{
		$new = $_POST['new'];
	}else{
		$resultArray['error_message'] = "Missing Field: Password";
		die(json_encode($resultArray));
	}
	if(isset($_POST['confirm']))
	{
		$confirm = $_POST['confirm'];
	}else{
		$resultArray['error_message'] = "Missing Field: Confirm";
		die(json_encode($resultArray));
	}
	if($new != $confirm)
	{
		$resultArray['error_message'] = "Passwords do not match";
		die(json_encode($resultArray));
	}

	//Validate this password
	if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,30}$/', $new)) 
	{
		$resultArray['error_message'] = "The password does not meet the requirements!\nPasswords must be 8 to 30 characters long and contain at least one special character or number.";
		die(json_encode($resultArray));
	}
	$new = crypt($new, $SALT);	
	
	$user = $_SESSION[$SV_USERNAME];
	
	//Make a user with just a name and password
	$myUserValues = array(
		"username"=>$user,
		"pass"=>$new
	);
	
	$myUser = new User($myUserValues);
	$myUser->setValue('id', $_SESSION[$SV_USERID]);
	$myUser->update();
		
	$resultArray['success_bool'] = true;
	$resultArray['success_message'] = "Password Changed.";


	echo(json_encode($resultArray));
?>