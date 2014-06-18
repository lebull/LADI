<?php 

/**
 *This file contains the definition of the DatabaseObjectManager class.
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
	
	/**
	 *Late Static Binding Function.  When implemented, should return the table name associated with this manager.
	 */
	public static function get_db_name()
	{
		die("Please define get_db_name() in the class you are using");
	}
	
	/**
	 *Late Static Binding Function.  When implemented, should return the table key associated with this manager.
	 */
	public static function get_db_index()
	{
		die("Please define get_db_index() in the class you are using");
	}
	
	/**
	 *Late Static Binding Function.  When implemented, should return the class name associated with this manager.
	 */
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
    public static function getAll($searchParams = array(), $orderKey = NULL)
	{
		global $DATABASE;
		
		$db_name = static::get_db_name();
		$db_index = static::get_db_index();
		$classname = static::get_class_var();
		
		$paramsArray = array();
		foreach($searchParams as $eachParam)
		{	
			if($eachParam->searchComp == 'MATCH')
			{
				$paramsArray['MATCH']['columns'] = array($eachParam->searchKey);
				$paramsArray['MATCH']['keyword'] = $searchParam->searchValue;
			}else{
				$param = $eachParam->getMedooParam();
				$paramsArray['AND'][$param[0]] = $param[1];
			}
		}
		if($orderKey != NULL)
		{
			$paramsArray['ORDER'] = $orderKey;
		}
		

		$queryResult = $DATABASE->select(
			$db_name,
			"*",
			$paramsArray
		);
		
		
		$resultArray = array();
		
		if($queryResult !== false)
		{
			foreach($queryResult as $resultRow)
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
		}
		
		
		
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
		try{
			foreach($objectArray as $printObject) $printObject->setPrintKeys($sortOrder);
		}catch(Exception $e){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}


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
			
			try{
				$fancyValues = $row->getFancyValues();
			}catch(Exception $e){
				throw new Exception("Missing Key in Database Object.  Check your sortOrder table");
			}
			
			foreach($fancyValues as $rowKey => $rowData)
			{
				echo("  <td>" . $rowData . "</td>\n");
			}
			echo("</tr>\n");
		}
	}
	
	/**
     * Generate an array fof search parameters from a 2d array created 
     *
     * @param array $inData A collection of form values used to search.
	 *
	 * @return array An array of search parameters
	 *
	 * @depricated
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