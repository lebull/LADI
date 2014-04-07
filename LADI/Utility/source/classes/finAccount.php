<?php
/**
 *This page contains a definition of an event object.
 *@package Crud
 */
 
/**
 *An event is a databaseObject that holds information pertaining to singular events.  The event objects also hold methods for creating, retrieving, and voiding payments.
 */
class FinAccount extends DatabaseObject{
	/**
	 *{@inheritdoc}
	 */
	protected $db_name = "budget_finAccount";
	/**
	 *{@inheritdoc}
	 */
	protected $db_index = "id";
	/**
	 *{@inheritdoc}
	 */
	protected $keyNames = array(
		"id" => "ID",
		"name" => "Name",
		"number" => "Acct. Num.",
		"active" => "Active"
	);		
	
//-------------Account Assignments--WIP-------//
	public function getManagers()
	{
		$returnArray = array();
		
		$con = connect_rw();
			
		$query = "SELECT budget_user.id " .
			"FROM budget_user_finAccount_join JOIN budget_user ON budget_user_finAccount_join.fk_user = budget_user.id " . 
			"JOIN budget_finAccount ON budget_finAccount.id = budget_user_finAccount_join.fk_finAccount " .
			"WHERE budget_finAccount.id = '"  . mysqli_real_escape_string($con, $this->getValue('id')) . "';";
			

		$result =  mysqli_query($con, $query) or $_SESSION[$SV_ERROR] = mysqli_error($con);
			
		mysqli_close($con);
		
		while($resultRow = mysqli_fetch_assoc($result))
		{
			array_push($returnArray, $resultRow['id']);
		}
		
		return $returnArray;
	
		
	}
	
//--------------Printing--------------//
    /**
     * Take a key (db column) and a value and turn it into a string that will be printed.
     *
     * @param $inKey string The key of the property that is to be printed.
     * @param $inValue string The raw value of the property that is to be printed
     * @param string $titleLink string A URL. If this is not null, it will link the printed title property to this url.  Do not include the get values.
     * @return mixed|string The result of the translation.
     */
    public function translateFancyValues($inKey, $inValue, $titleLink = NULL)
	{
		switch($inKey){
			
				//If we're displaying a date, it needs to be converted
				case "name":
					$outValue = "<a href='/Budget/FinAccount/editFinAccountForm.php?id=" . $this->getValue('id') . "' class='button_grey' style='width;100%'>" . $inValue . "</a>";
					break;
				case "active":
					if($inValue == '0')
						$outValue = "<span style='color:red;'>Inactive</span>";
					if($inValue == '1')
						$outValue = "<span style='color:green;'>Active</span>";
					break;
				default:
					$outValue = $inValue;		
		}	
		
		return($outValue);
	}
}
?>