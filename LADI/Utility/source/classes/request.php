<?php
/**
 *This page contains a definition of an event object.
 *@package Crud
 */
 
/**
 *An event is a databaseObject that holds information pertaining to singular events.  The event objects also hold methods for creating, retrieving, and voiding payments.
 */
class Request extends DatabaseObject{
	/**
	 *{@inheritdoc}
	 */
	protected $db_name = "budget_request";
	/**
	 *{@inheritdoc}
	 */
	protected $db_index = "id";
	/**
	 *{@inheritdoc}
	 */
	protected $keyNames = array(
		"id" => "ID",
		"request_date" => "Date",
		"fk_finAccount" => "Account",
		"fk_author" => "Author",
		"fk_vendor" => "Vendor",
		"quantity" => "Quantity",
		"cost_each" => "Cost Each",
		"total_cost" => "Total Cost",
		"product" => "Product",
		"manager_approval" => "Manager App.",
		"fk_manager" => "Manager",
		"description" => "Description",
		"financial_approval" => "Financial App."
	);
	

	
//--------------Printing--------------//
    /**
     * Take a key (db column) and a value and turn it into a string that will be printed.
     *
     * @param $inKey string The key of the property that is to be printed.
     * @param $inValue string The raw value of the property that is to be printed
     * @param string $titleLink string A URL. If this is not null, it will link the printed title property to this url.  Do not include the get values.
     * @return mixed|string The result of the translation.
     */
    public function translateFancyValues($inKey, $inValue)
	{
		switch($inKey){
			
				//If we're displaying a date, it needs to be converted
				case "id":
				//case "product":
					$outValue = "<a href='/Budget/Request/viewRequestForm.php?id=" . $this->getValue('id') . "' style='width;100%' class='button_black'>" . $inValue . "</a>";
					break;
					
				case "request_date":
					$date = explode(" ", $inValue);
					$outValue = $date[0];
					break;				
				
				case "fk_author":
				case "fk_manager":
					$myUser = new User();
					$myUser->getByID($inKey);
					if($myUser->checkValues(array('user')))
					{
						$outValue = $myUser->getValue('user');
					}
					break;
				
				
				case "fk_finAccount":
					$outValue = $inValue;
					
					
					$account = new FinAccount();
					$account->getByID($inValue);
					if($account->checkValues(array('name')))
					{
						$outValue = $account->getValue('name');
					}
					break;
				
				case "fk_vendor":
					$outValue = $inValue;
					
					
					$myVendor = new Vendor();
					
					
					$myVendor->getByID($inValue);
					if($myVendor->checkValues(array('name')))
					{
						$outValue = $myVendor->getValue('name');
					}

					
					break;
					
				case "financial_approval":	
					if($this->getValue('manager_approval') != 1)
					{	
						$outValue = "-";
						break;
					}
					
				case "manager_approval":
					if($inValue == '-1')
						$outValue = "<span class='declinedText'>Declined</span>";
					if($inValue == '0')
						$outValue = "<span class='pendingText'>Pending</span>";
					if($inValue == '1')
						$outValue = "<span class='approvedText'>Approved</span>";
					break;
					
					

					
				
				default:
					$outValue = $inValue;		
		}	
		
		return($outValue);
	}
}
?>