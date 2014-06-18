<?php
/**
*This file contains the definition for the search parameter class.
*/

/**
*This class is a wrapper for search parameters.
*/



class SearchParameter{
	
	/**
	*
	*Constructor for the search parameter.  This class is used only by manager classes.
	*
	*@param string $searchKey The key that is relevent to a search.
	*@param string $searchValue The value that is being compared to.
	*@param string $searchComp  The method of comparison that is used in a search.  For example, '=', '>', or '<'.
	*
	*@throws InvalidArgumentException if the argument is not a comparison.
	*/
	public function searchParameter($searchKey, $searchValue, $searchComp){
		
		//Make sure that the comp parameter actually makes sense.
		$allowedComps = array("=", "!=", ">", "<", "<=", ">=", "LIKE", "REGEXP", "!");
		if(!in_array($searchComp, $allowedComps))
		{
			$exceptionText = 'The provided comparison method (argument 3) is not valid.  Allowed comparisons: ';
			foreach ($allowedComps as $myException)
			{
				$exceptionText .= $myException . " ";
			}
			throw new InvalidArgumentException($exceptionText);
			
		}
		
		$this->searchKey = $searchKey;
		$this->searchValue = $searchValue;
		$this->searchComp = $searchComp;
	}
	
	/**
     * Generate an array fof search parameters from a 2d array created in an html form.  
	 * NOTE: if an element's name ends in _comp, this value will be used as the comparison.
     *
     * @param array $inData A collection of form values used to search.
	 *
	 * @return array An array of search parameters
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

	
	/**
	 *Returns an array that represents a format used for the meboo database.
	 *
	 *@return array[2] First element is the key and comparison ('key[>]'), second key is the value. 
	 */
	public function getMedooParam()
	{
		return array(sprintf("%s[%s]", $this->searchKey, $this->searchComp), $this->searchValue);
	}
}
?>