<?php
/**
*This file contains the definition for the search parameter class.
*/

/**
*This class is a wrapper for search parameters.
*/
class searchParameter{
	
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
		$allowedComps = array("=", "!=", ">", "<", "<=", ">=", "LIKE", "REGEXP");
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
}
?>