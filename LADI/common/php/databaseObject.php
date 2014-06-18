<?php
/**
 *This page contains a class definition of the database object.
 *@package Crud
 */
 
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/medoo/medoo.min.php";
 
/**
 *This is the database object abstract class.  
 *
 *A databaseObject is any object stored in the database that is not exclusively associated with a parent object.  In the context of the marketing application, this applies to request objects and user objects. The vital piece of information stored in this object is the values property.  The values property is an associative array whose keys correspond to column names in the database and whose values corrispond to the column values.
 *
*/


abstract class DatabaseObject{
	
	/**
	 * @var array An associative array that reflects the data stored in the database.
	 */
	private $values = array();
	
	/**
	 * @var array An array of strings that contain keys.  When printing an object, this is array dictates the order the values are printed.  Not every key has to be present in this array.
	 */
	private $printKeys = array();
	
	/**
	 * @var string The name of the sql table that a DatabaseObject uses.
	 */
	protected $db_name;
	
	/**
	 * @var string The main index in the databaseObject's corrisponding table.  Used for searching and retrieving databaseObjects that already exist.
	 */
	protected $db_index;
	
	/**
	 * @var array An associative array that maps the database's key names to human-readable names.
	 */
	protected $keyNames = array();

	/**
	 * @var string The human-readable name of the class.
	 */
	protected $myClassName;
	
	/**
	 *@var medoo An instance of a medoo database class.
	 */
	
	
//------------ Constructor----------------//
	/**
     *Constructor for the database object.  Responsible for building the array of values.
     *@param array $inValues An associative list that represent the columns and properties of an entry in the database.
     */
	public function __construct(array $inValues = NULL)
	{
		$this->myClassName = get_class($this);
		$this->setValues($inValues);
	}
	
	/**
	 * Construct an instance of this class based on a given id.
	 * @param $inID the id of the database entry desired.
	 * 
	 * @return self Returns an instance of this class. (no clue how to document this).
	 */
	public static function constructByID($inID)
	{
		$returnObject = new self();
		$returnObject->getByID($inID);
		return $returnObject;
		
	}

//------------ CRUD (Female) --------------//
    /**
     * Creates the object as a row in the database.
	 *
     * @return bool Returns true if the query is successful.
     * I was apperiently too lazy to fix this.  Commencing yelling in the hopes that future-me or future student worker sees this.
     */
    public function create()
	{
		global $DATABASE;
		$returnBool = false;
		$inData = $this->getValues();
		
		$insertID = $DATABASE->insert($this->db_name, $inData);
		if($insertID != false)
		{
			$returnBool = true;
			$this->setValue($this->db_index, $insertID);
		}else{
			$returnBool = false;
		}

		return $returnBool;
	}

	/**
     *Pulls a row from the database and builds the object from that.
	 *
	 *@param $id The id of the requested object.
	 *@return bool Returns true if the query is successful.
     */
	public function getByID($id)
	{		
		global $DATABASE;
		
		$queryData = $DATABASE->select($this->db_name, "*", array($this->db_index => $id));
		$newObjectValues = $queryData[0];

		if($queryData !== false)
		{
			$this->setValues($newObjectValues);
			$returnBool = true;
		}else{
			$returnBool = false;
		}
		return $returnBool;
	}


	/**
	 *Get an associative array of a single object identified by its id.
	 *
	 *@return bool Returns true if the query is successful.
	 *@todo Since adding medoo, this function always returns true.  Rows affected is a bad measurement for failure since other parts may update in inherited classes.
	 */
	public function update(){
		
		global $DATABASE;

		$inData = $this->getValues();
		
		$rowsAffected = $DATABASE->update($this->db_name, $inData, array($this->db_index => $this->getID()));
		
		return true;
	}
	
//-------------Values---------------------//

	/**
	 *Returns a copy of the values property
	 *
	 *@return array Returns a copy of the values property.
	 */
	public function getValues()
	{
		return $this->values;
	}

	/**
	 *Reassigns the values property
	 *
	 *@param inValues An associative array that the values property will be assigned to.
	 */
	public function setValues(array $inValues=NULL)
	{	

		if(isset($inValues) and $inValues != NULL){
			$this->values = $inValues;
		}
	}
	
	/**
	 *Returns a copy of a particular element of the values array.
	 *
	 *@param $inKey The key of the desired element
	 *
	 *@return string
	 */
	public function getValue($inKey)
	{

		//Still haven't figured out the error handling
		
		
		if(!isset($this->values[$inKey]))
		{
			trigger_error("Key '$inKey' could not be found.", E_USER_ERROR);
		}
		
		$returnValue = $this->values[$inKey];
		return $returnValue;
		
	}

	/**
	 *Assigns a single element in the values property
	 *
	 *@param $inKey The key of the element that is to be updated
	 *@param $inValue The new value that the element will be assigned to.
	 */
	public function setValue($inKey, $inValue)
	{
		$this->values[$inKey] = $inValue;
	}
	
	/**
	* Returns all keys in the values property
	*
	* @return array string[] An array of keys that corrispond to the the values property.
	*/
	public function getKeys()
	{
		$keyArray = array_keys($this->getValues());
		return $keyArray;
	}
	
	/**
	* Returns the name of the index
	*
	* @return string db_index The name of this object's index
	*/
	public function getIndexName()
	{
		return $this->db_index;
	}

	/**
	* Returns the id of this object
	*
	* @return string The index of this object
	*/
	public function getID()
	{
		return $this->getValue($this->db_index);
	}
	
	/**
     *Removes a value from the object's value property.
	 *NOTE: THIS DOES NOT REMOVE THE VALUE IN THE DATABASE.
	 *
	 *@param $valueName The name of the value to unset.
     */
	public function unsetValue($valueName)
	{
		unset($this->values[$valueName]);
	}
//-------------JSON Formatting Help--------//
	/**
     * Take a key (db column) and a value and return it's corrisponding value that filtered for use with json.
     * EG. Some vendors have single quotes in their names or cities.  Some have line breaks for some reason only god knows.
	 * These should be removed.
	 *
     * @param $inKey string The key of the property that is to be returned.
     * @return mixed|string The result of the translation.
     */
	public function getFilteredValue($inKey)
	{	
		$returnValue = $this->getValue($inKey);
		$returnValue = str_replace("'", "\'", $returnValue);
		$returnValue = str_replace("\n", " ", $returnValue);
		
		return $returnValue;
	}

//-------------Printing-------------------//
    /**
     * //Take a key (db column) and a value and turn it into a string that will be printed.
     *
     * @param $inKey
     * @param $inValue
     * @return mixed
     */
    public function translateFancyValues($inKey, $inValue)
	{
		return($inValue);
	}
	
	/**
     * //Returns an array of all fancy values from the object's current values.
     *
     * @return array string[]
     */
	public function getFancyValues()
	{
		
		$returnArray = array();
		$keyArray = $this->printKeys;
		$rowValues = $this->getValues();
		
		foreach($keyArray as $rowKey){
			if(!array_key_exists($rowKey, $rowValues))
			{
				throw new Exception("Key '" . $rowKey . "' not found in databaseObject.");
			}
			$rowValue = $rowValues[$rowKey];
			$returnArray[$rowKey] = $this->translateFancyValues($rowKey, $rowValue);
		}
		return $returnArray;
	}
	
	/**
	 *Return a human-readable (fancy) version of a single particular value.
	 *
	 *@param string $inKey The key of the desired value.
	 *
	 *@return string The fancy value of the requested value.
	 */
	public function getFancyValue($inKey)
	{
		$inValue = $this->getValue($inKey);
		return $this->translateFancyValues($inKey, $inValue);
	}


    /**
     * Returns all keys in the values property, but in a formatted manner.
     *
     * @return array
     */
    public function getFancyKeys(){
		$returnArray = array();
		$keyArray = $this->printKeys;

		foreach($keyArray as $keyRow)
		{
				array_push($returnArray, $this->tableKeyToFancyKey($keyRow));
		}
		return $returnArray;
	}

    /**
     * Sets the printKeys property.  This is just an array of formatted keys.
     *
     * @param null $inValues
     */
    public function setPrintKeys($inValues = NULL)
	{
		if($inValues == NULL)
		{
			$inValues = array_keys($this->getValues());
		}
		$this->printKeys = array();
		foreach($inValues as $inRow)
		{
			array_push($this->printKeys, $inRow);
		}
	}

    /**
     * Converts the table column name to a formatted table name.
     *
     * @param string $tableKey Should this function consider a blank string to be non-existant?  True by default.
     * @return mixed True if all values exist in the values property.
     */
    public function tableKeyToFancyKey($tableKey){
	
		$returnName = $tableKey;
		
		if(array_key_exists($tableKey, $this->keyNames)){
			$returnName = $this->keyNames[$returnName];
	
		}
		
		return $returnName;
	}
//-------------Utility--------------------//
    /**
     * Prints a string representation of the object.
     */
    public function toString()
	{
		$returnString = "";
		$varArray = get_object_vars($this);
		foreach($varArray as $varName=>$var){
			if(is_array($var))
			{
				foreach($var as $varKey => $varValue){
					if(is_array($varValue))
					{
						echo($varKey . ": ");
						foreach($varValue as $varValueRow)
							echo($varValueRow . ", ");
						echo("<br />");
					}
					else
					{
						echo($varKey . ": " . $varValue . "<br />");
					}
				}
			}else{
				echo($varName . ": " . $var);
			}
			
		}
	}

    /**
     * Checks to see if certain values exist in the object's values property.
     *
     * @param array $inKeys  An array of keys to be checked.
     * @param bool $includeBlank  True if this function should consider empty strings.  True by default.
	 *
     * @return bool True if all values exist in the values property.
     */
    public function checkValues(array $inKeys, $includeBlank = true)
	{
		global $SV_ERROR;
		global $SV_MESSAGE;
		
		$returnBool = true;
		foreach($inKeys as $inValue)
		{
			
			//If the value is blank OR (we want it to count nullstrings and the value is a nullstring)
			if(!array_key_exists($inValue, $this->values) or ($includeBlank == true and $this->values[$inValue] == ""))
			{
				//$_SESSION[$SV_ERROR] = "Missing Value: " . $this->tableKeyToFancyKey($inValue);
				$returnBool = false;
			}
	
		}
		return $returnBool;
	}
}
?>