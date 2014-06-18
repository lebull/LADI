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
	protected $db_name = "travel_request";
	/**
	 *{@inheritdoc}
	 */
	protected $db_index = "id";
	/**
	 *{@inheritdoc}
	 */
	protected $keyNames = array(
		"id" => "ID.",
		"timestamp" => "Timestamp",
		"location" => "Location",
		"fk_author" => "Author",
		"travel_date" => "Travel Date",
		"needed_date" => "Needed Date",
		"fk_setupType" => "Setup Type",
		"attendance" => "Attendance",
		"open" => "Open"
	);
	
//--------------Crud------------------//
	/**
     * Update a row to the database with each key/value of the values array as a column/property.  Uses request_id as the main key.
     */
    public function create(){
		$inData = $this->getValues();
		
		//Sync Items
		if(array_key_exists('item_requested_quantities', $this->getValues()))
		{
			$requestedItems = $this->getValue('item_requested_quantities');
			$this->unsetValue('item_requested_quantities');
		}
	
		if(array_key_exists('item_granted_quantities', $this->getValues()))
		{
			$grantedArray = $this->getValue('item_granted_quantities');
			$this->unsetValue('item_granted_quantities');
		}
		
		if(count($inData) > 1)
		{
			$resultBool = parent::create($inData);
			if(isset($requestedItems))
			{
				$this->syncItems($requestedItems, 'requested');
			}
			
			if(isset($grantedArray))
			{
				$this->syncItems($grantedArray, 'granted');
			}
			
		}else{
			$resultBool = true;
		}
		return $resultBool;
	}

    /**
     * Update a row to the database with each key/value of the values array as a column/property.  Uses request_id as the main key.
     */
    public function update(){

		$inData = $this->getValues();
		//Add a comment
		if(isset($inData['comment'])){
			if($inData['comment'] != "")
			{
				$this->addComment($inData['comment']);
			}
			unset($inData['comment']);
		}
		
		//Sync Items
		if(array_key_exists('item_requested_quantities', $this->getValues()))
		{
			$this->syncItems($this->getValue('item_requested_quantities'), 'requested');
			$this->unsetValue('item_requested_quantities');
		}
		
		if(array_key_exists('item_granted_quantities', $this->getValues()))
		{
			$this->syncItems($this->getValue('item_granted_quantities'), 'granted');
			$this->unsetValue('item_granted_quantities');
		}
	
		
		
		if(count($inData) > 1)
		{
			$resultBool = parent::update($inData);
		}else{
			$resultBool = true;
		}
		return $resultBool;
	}
	
	/**
	 *{@inheritdoc}
	 *
	 *@param $inID The id of the databaseObject desired.
	 *
	 *@todo Return false if it doesn't exist
	 */
	public function getByID($inID)
	{
		$returnBool = parent::getByID($inID);
		if($returnBool)
		{
			$this->setValue('comments', $this->getComments());
			$this->setValue('item_requested_quantities', $this->getItems('requested'));
			$this->setValue('item_granted_quantities', $this->getItems('granted'));
		}
		
		return $returnBool;
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
    public function translateFancyValues($inKey, $inValue)
	{
		switch($inKey){
			
				//If we're displaying a date, it needs to be converted
				case "id":
				//case "product":
					$outValue = "<a href='/Travel/Request/viewRequestForm.php?id=" . $this->getValue('id') . "' style='width;100%' class='button_black'>" . $inValue . "</a>";
					break;
								
				
				case "fk_author":
					$outValue = $inValue;
					$myUser = new User();
					$myUser->getByID($inValue);
					if($myUser->checkValues(array('username')))
					{
						$outValue = $myUser->getValue('username');
					}
					break;
					
				case "fk_setupType":
					$outValue = $inValue;
					$mySetupType = new SetupType();
					$mySetupType->getByID($inValue);
					if($mySetupType->checkValues(array('name')))
					{
						$outValue = $mySetupType->getValue('name');
					}
					break;
				case "open":
					$outValue = $inValue;
					if($inValue == '1')
					{
						$outValue = "Open";
					}
					elseif($inValue == '0')
					{
						$outValue = "Closed";
					}
					break;
				default:
					$outValue = $inValue;		
		}	
		
		return($outValue);
	}

	//--------------Comments--------------//
    /**
     * Add a comment to a request request.  Comments are not saved in the request table of the database.  Uses request_id as the associative key.
     *
     * @param string $comment This is the body of the comment.
     */
    public function addComment($comment)
	{
		
				global $DATABASE;
				global $SV_ERROR;
				global $SV_USERID;
			
				
				$addComment = array(
					"comment" => $comment,
					"fk_user" => $_SESSION[$SV_USERID],
					"fk_request" => $this->getValue($this->db_index)
				);
				
				$DATABASE->insert('travel_request_comment', $addComment);
				
				return true;
	}
	

    /**
     * Gets all comments associated with this request.  Comments are not saved in the request table of the database.  Uses request_id as the associative key.
     *
     * @return array string[].  An array of strings(comments) that are associated with this request.
	 *@todo make sure these comment docblocks are consistant
     */
    private function getComments()
	{
		global $DATABASE;
		return $DATABASE->select('travel_request_comment', "*", array('fk_request' => $this->getID()));
	}
	
	
	/*-----------------Item Information-------------------*/	
			
	/**
	 *Retrieve an array of all items associated with this request.
	 *
	 *@param getType Whether this is a requested item or granted item.
	 *
	 *@return array An array of all quantities of items associated with this request.
	*/
	//$joinTable, $otherTable
	private function getItems($getType)
	{	
		global $DATABASE;
		$result = $DATABASE->select(
			"travel_item", 																	//Db name
			array('[><]travel_' . $getType . '_items_join' => array('id' => 'fk_item')),	//Join 
			array('travel_item.id', 'travel_' . $getType . '_items_join.quantity'),			//Select keys
			array('travel_' . $getType . '_items_join.fk_request' => $this->getID())		//Where
		);
		
		$resultArray = array();
		
		foreach($result as $row)
		{
			$resultArray[$row['id']] = $row['quantity'];
		}
		return $resultArray;
	}
	
	/**
	 *Assign an array of items ids to this request.
	 *
	 *@param $inArray An associative array of items to assign to this user.  Key is item id, value is the quantity.  This allows us to easilly pull the values from the form.
	 *
	 *@param getType Whether this is a requested item or granted item.  (either 'requested' or 'granted').
	 *
	 */
	//public function syncItems($inTable, array $inArray)
	private function syncItems(array $inArray, $getType)
	{
		global $DATABASE;
		$inTable = "travel_" . $getType . "_items_join";
		$otherKey = 'fk_request';
		
		//Delete the ones that are already there.
		$rowsAffected = $DATABASE->delete($inTable, array("fk_request" => $this->getID()));
		
		//Add each item in inArray to 
		foreach($inArray as $inKey=>$inQuantity)
		{
			//We don't want to add items that are 0
			if($inQuantity != '0')
			{
				$addItem = array(
					'fk_request' => $this->getValue('id'),
					'fk_item' => $inKey,
					'quantity' => $inQuantity
				);
				$DATABASE->insert($inTable, $addItem);
			}
		}
	}

}


?>