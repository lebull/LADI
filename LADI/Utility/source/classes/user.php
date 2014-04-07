<?php
/**
 *This page contains a definition of the User databaseObject class.
 */
 
 
/**
 * This class handles information about individual users of this system.  It is somewhat tied to the login system (It is used to add users, but the login script does not use this class).
 * *Note:* The user class NEVER handles the user's password, except immediately after a get statement.  It should remove the password from the parameter list ASAP!
 */


class User extends DatabaseObject{
	
	/**
	 *{@inheritdoc}
	 */
	protected $db_name = "budget_user";
	
	/**
	 *{@inheritdoc}
	 */
	protected $db_index = "id";
	
	/**
	 *{@inheritdoc}
	 */
	protected $keyNames = array(
		"id" => "id",
		"user" => "Username",
		"permissions" => "Permissions",
		"email" => "Email",
		"account" => "Account"
	);
	
	/**
	 *(@inheritdoc)
	 */	 
	public function getByID($id)
	{
		$returnValue = parent::getByID($id);
		$this->setValue('accounts', $this->getAccounts());
		return $returnValue;
	}
	
	/*-------------Update----------------*/
	
	/**
	 *{@inheritdoc}
	 */	
	public function update()
	{
		
		$returnValue = false;
		if(array_key_exists('accounts', $this->getValues()))
		{
			$this->assignAccounts($this->getValue('accounts'));
			$this->unsetValue('accounts');
		}
		
		$returnValue = parent::update();
		return $returnValue;
		
	}
	
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

				case "user":
						$outValue = ("<a href=\"/Budget/User/editUserForm.php?id=" . $this->getValue('id') . "\">" . $inValue . "</a>");
					break;
				case "email":
					$outValue = '<a href="mailto:' . $inValue . '">' . $inValue . '</a>';
					break;
					

					
				//If we're displaying a date, it needs to be converted
				case "permissions":
					$outValue = $inValue;
					if($inValue == "0")$outValue = "Standard";
					if($inValue == "1")$outValue = "Admin";
					if($inValue == "2")$outValue = "Finance User";
					break;
					
				default:
					$outValue = $inValue;		
		}	
		
		return($outValue);
	}
	
	
	/*---------------Account Assignments---------------------*/
	/**
	 * Add a row to the budget_user_finAccount_join table.  This represents an assignment between a user and a finAccount.
	 *
	 * @param string $inID string The id of the finAccount to assign this user to.
	 * @return bool Returns false on an sql error.
	 */
	public function addAccount($inID)
	{
		
		$itWorked = true;
		
		$alreadyAssigned = $this->getAccounts();
		
		if(!in_array($inID, $alreadyAssigned))
		{
			$con = connect_rw();
			$query = "INSERT INTO budget_user_finAccount_join (fk_user, fk_finAccount)
						VALUES (" . $this->getValue('id') . ", " . mysqli_real_escape_string($con, $inID) . ")";
			mysqli_query($con, $query) or $itWorked = false;
			mysqli_close($con);
		}
		
		return $itWorked;	
	}
	
	
	/**
	 * Remove a row to the budget_user_finAccount_join table.  This represents an assignment between a user and a finAccount.
	 *
	 * @param string $inID string The id of the finAccount to remove unassign.
	 * @return bool Returns false on an sql error.
	 */	
	public function removeAccount($inID)
	{
		$itWorked = true;
		
		$alreadyAssigned = $this->getAccounts();
		if(in_array($inID, $alreadyAssigned))
		{
			$con = connect_rw();
			$query = "DELETE FROM budget_user_finAccount_join
				WHERE fk_user='" . $this->getValue('id') . "' AND fk_finAccount = '" . mysqli_real_escape_string($con, $inID) . "';";
				
			mysqli_query($con, $query) or $itWorked = false;
			mysqli_close($con);
		}
		
		return $itWorked;
	}
	
	/**
	 *Retrieve an array of all accounts associated with this user.
	 *
	 *@return array An array of all ids of finAccounts associated with this user.
	*/
	public function getAccounts()
	{
		
		global $SV_ERROR;
		
		$returnArray = array();
		
		$con = connect_rw();
		
		$query = "SELECT budget_finAccount.id " .
			"FROM budget_user_finAccount_join JOIN budget_user ON budget_user.id = budget_user_finAccount_join.fk_user " . 
			"JOIN budget_finAccount ON budget_finAccount.id = budget_user_finAccount_join.fk_finAccount " .
			"WHERE budget_user.id = '"  . mysqli_real_escape_string($con, $this->getValue('id')) . "';";
	
			

		$result =  mysqli_query($con, $query) or $_SESSION[$SV_ERROR] = mysqli_error($con);
		mysqli_close($con);
		
		while($resultRow = mysqli_fetch_assoc($result))
		{
			array_push($returnArray, $resultRow['id']);
		}
		
		return $returnArray;
	}
	
	public function assignAccounts($inArray)
	{
		if(!is_array($inArray)) trigger_error(__FUNCTION__ . " parameter 1 Expected Array, got " . gettype($inArray) ,E_USER_ERROR);
		
		//Get the accounts that we're already assigned to
		$alreadyAssigned = $this->getAccounts();
		
		//Determine which accounts need to be added.  If it's not already there, we need to add it.
		$addArray = array();
		
		foreach($inArray as $inKey=>$inAccount)
		{
			if(!in_array($inAccount, $alreadyAssigned))
			{
				array_push($addArray, $inAccount);
			}
		}
		

		//Determine which accounts need to be removed
		$removeArray = array();
		
		foreach($alreadyAssigned as $alreadyKey=>$alreadyAccount)
		{
			if(!in_array($alreadyAccount, $inArray))
			{
				array_push($removeArray, $alreadyAccount);
			}
		}
		
		//Add and remove as needed
		foreach($addArray as $addID)
		{
			$this->addAccount($addID);
		}
		
		foreach($removeArray as $removeID)
		{
			$this->removeAccount($removeID);
		}
	}
}



?>