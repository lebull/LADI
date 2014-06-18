<?php
/**
 *This page contains a definition of the User databaseObject class.
 */
 
 
/**
 * This class handles information about individual users of this system.  It is somewhat tied to the login system (It is used to add users, but the login script does not use this class).
 * *Note:* The user class NEVER handles the user's password, except immediately after account statement.  Remove the password from the object ASAP!
 */


class User extends DatabaseObject{
	
	/**
	 *{@inheritdoc}
	 */
	protected $db_name = "travel_user";
	
	/**
	 *{@inheritdoc}
	 */
	protected $db_index = "id";
	
	/**
	 *{@inheritdoc}
	 */
	protected $keyNames = array(
		"id" => "id",
		"username" => "Username",
		"permissions" => "Permissions",
		"email" => "Email",
		"account" => "Account"
	);
	

	
	/*-------------Printing---------------*/
    /**
     * Take a key (db column) and a value and turn it into a string that will be printed.
     *
     * @param string $inKey string  The key of the property that is to be printed.
     * @param string $inValue string The raw value of the property that is to be printed
     * @return mixed|string The result of the translation.
     */
    public function translateFancyValues($inKey, $inValue)
	{
		switch($inKey){

				case "username":
						$outValue = ("<a href=\"/Travel/User/editUserForm.php?id=" . $this->getValue('id') . "\">" . $inValue . "</a>");
					break;
				case "email":
					$outValue = '<a href="mailto:' . $inValue . '">' . $inValue . '</a>';
					break;
					

					
				//If we're displaying a date, it needs to be converted
				case "permissions":
					$outValue = $inValue;
					if($inValue == "0")$outValue = "Standard";
					if($inValue == "1")$outValue = "Admin";
					break;
					
				default:
					$outValue = $inValue;		
		}	
		
		return($outValue);
	}
}



?>