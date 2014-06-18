<?php
/**
 *This file is responsible for listing functions that describe the accessability of various objects per user.
 *
 *@This should probably be implemented in the DatabaseObjectManager class.
 */



/**
 *Determines if a particular user is allowed to view a particular request
 *
 *@param $inUser A user object representing user in question 
 *@param $inRequest The id of the Request in question
 *
 *@return bool Return true if access is allowed
 */
function userCanViewRequest($inUser, $inRequest)
{
	if($inUser->checkValues(array('permissions')) == false)
	{
		throw new Exception("Parameter 1 inUser doesn't have permissions listed.  Make sure you're using getByID or setValue('permissions')");
		return false;
	}
	
	$user_id = $inUser->getValue('id');	
	$user_permissions = $inUser->getValue('permissions');
	
	//Standard Users - It's either our request or we are allowed to view this account's requests
	if($user_permissions === '0' 
		and(
			//It's our request
			$user_id == $inRequest->getValue('fk_author')
		)
	)
	{
		return true;
	}
	
	//If we're a manager, free reign.
	if($user_permissions === '1')
	{
		return true;	
	}
	
	//If we're a financial user, free reign.
	if($user_permissions === '2')
	{
		return true;
	}
	
	return false;
}
?>