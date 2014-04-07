<?php 

/**
 *This file contains the definition of the FinAccountManager manager class.
 */

/**
 *The Event Manager is responsible for handling anything that involves multiple users.  It should include things like getting multiple users from the database and displaying the users in a table format.
 *
 *This class also contains methods for handling fees for some mysterious reason
 *
 *@todo Move fees methods to its own manager class.
 */

abstract class DatabaseObjectManager{
	

	
	//Late static bindings
	//http://www.php.net/manual/en/language.oop5.late-static-bindings.php
	public static function get_db_name()
	{
		die("Please define get_db_name() in the class you are using");
	}
	
	public static function get_db_index()
	{
		die("Please define get_db_index() in the class you are using");
	}
	
	public static function get_class_var()
	{
		die("Please define get_db_index() in the class you are using");
		return 'DatabaseObject';
	}
	
    /**
     * Return an array of all databaseObjects with given search parameters.
     *
	 * @param array $searchParams An array of search parameters that will be considered when getting databaseObjects.
	 *
     * @return array An array of databaseObjects.
     */
    public static function getAll($searchParams = array())
	{
		if(!is_array($searchParams))
		{
			trigger_error("SearchParams must be an argument", E_USER_ERROR);
		}
		
		global $SV_ERROR;
		$con = connect_rw();   
		
		//**Handle Search Parameters**//
		$orderTag = " ORDER BY " . static::get_db_name()  . "." .  static::get_db_index() . " DESC";
		
		$limitString = "";	//Set the limit of how many databaseObjects to get.
		$paramString = "";	//Build the parameter string from the provided list of parameters.
		
		//Take our array of search parameters and 
		foreach($searchParams as $paramKey=>$param){
	
			$key = mysqli_real_escape_string($con, $param->searchKey);
			$value = mysqli_real_escape_string($con, $param->searchValue);
			$comp = mysqli_real_escape_string($con, $param->searchComp);
															
			//This switch will generate a search parameter string from the given search parameters.  
			//Set as a switch to handle specialized things such as dates.
			switch($key){	
					default:
					$paramString .= " AND " . static::get_db_name() . "." . $key . " " . $comp . " '" . $value . "'";
				}
		}
		
		//**Execute query**//
		$query = "SELECT * FROM " . static::get_db_name() . " WHERE 1 $paramString $orderTag;";
		
		$result = mysqli_query($con, $query) or $_SESSION[$SV_ERROR] = mysqli_error($con);
		$resultArray = array();
		
		while(gettype($result) != "boolean" and $resultRow = mysqli_fetch_assoc($result))
		{
			//The actual constructor we call depends on which object this manager class uses.
			//We need to use a reflection class.  This is basically a class that mimics another class.
			//http://stackoverflow.com/questions/16604251/call-arbitrary-constructor-with-arbitrary-arguments
			$class = static::get_class_var();
			$args = array($resultRow);
			$reflection = new ReflectionClass($class);
			$classInstance = $reflection->newInstanceArgs($args);

			array_push($resultArray, $classInstance);
		}
		mysqli_close($con);
		return $resultArray;
	}

    /**
     * Print a table of databaseObjects.  Each value is printed with the corrisponding object's fancy values.
     * NOTE:  When this is printed, it does not include the surrounding table tags.  This is to allow the formatting of the table.
     *
     * @param array $objectArray This contains a list of all databaseObjects to be sorted.
     * @param array $sortOrder This will denote the order that the users will be printed in.
     */
    public static function printTable(array $objectArray, array $sortOrder)
	{
		//write the results as a table.
		foreach($objectArray as $finAccount) $finAccount->setPrintKeys($sortOrder);


		//Flag to print the table header during the first pass.
		$firstPass = TRUE;

		//write the results as a table.
		foreach($objectArray as $row)
		{

			//Print the table header
			if($firstPass)
			{
				echo("<tr>");
				foreach($row->getFancyKeys() as $rowKey)
				{
					echo("  <th>" . $rowKey . "</th>\n");
				}
				echo("</tr>");
				$firstPass = FALSE;
			}
			echo("<tr>\n");

			//Echo each row of data
			$indexName = $row->getIndexName();
			foreach($row->getFancyValues($row->getValue($indexName)) as $rowKey => $rowData)
			{
				echo("  <td>" . $rowData . "</td>\n");
			}
			echo("</tr>\n");
		}
	}
	
	/**
     * Generate an array fof search parameters from a 2d array created 
     *
     * @param array $objectArray This contains a list of all databaseObjects to be sorted.
     * @param array $sortOrder This will denote the order that the users will be printed in.
     */
	public static function generateSearchParameters($inData)
	{
		//This string will be inserted into the query to get these requests.
		$searchParams = array();
		
		//Grab all of the values and switch them over to 
		foreach($inData as $inKey => $inValue)
		{
			//If it's not empty
			if(($inValue != '')
				 and ($inValue != NULL)
				 
				 //Or just picking up something from a drop down to select a comparison.
				 and (substr($inKey, -5) != '_comp'))
			{
				$comp = "=";

				if(isset($inData[$inKey . '_comp'])) $comp = $inData[$inKey . '_comp'];
				
				$mySearchParameter = new SearchParameter($inKey, $inValue, $comp);
				array_push($searchParams, $mySearchParameter);
			}
		}
		return $searchParams;
	}

}
//Try searching with this :D
//http://stackoverflow.com/questions/18415820/mysql-is-it-possible-to-use-like-on-all-columns-in-a-table
?>