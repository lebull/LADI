<?php
/**
 *This page contains a definition of an event object.
 *@package Crud
 */
 
/**
 *An event is a databaseObject that holds information pertaining to singular events.  The event objects also hold methods for creating, retrieving, and voiding payments.
 */
class Item extends DatabaseObject{
	/**
	 *{@inheritdoc}
	 */
	protected $db_name = "travel_item";
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
		"quantity" => "Quantity",
		"active" => "Active"
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
					$outValue = "<a href='/Travel/Item/editItemForm.php?id=" . $this->getValue('id') . "' class='button_black' style='width;100%'>" . $inValue . "</a>";
					break;
				case "active":
					$outValue = $inValue;
					if($inValue == "0") $outValue = "Inactive";
					if($inValue == "1") $outValue = "Active";
					break;

				default:
					$outValue = $inValue;		
		}	
		
		return($outValue);
	}
}
?>