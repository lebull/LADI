<?php 

/**
 *This file contains the definition of the VendorManager manager class.
 */

/**
 *@inheritdoc
 *
 *The VendorManager is responsible for handling anything that involves multiple vendors.  It should include things like getting multiple users from the database and displaying the users in a table format.
 */
class RequestManager extends DatabaseObjectManager{
	
	//Late static bindings
	//http://www.php.net/manual/en/language.oop5.late-static-bindings.php
	
	/**
	 *{@inheritdoc}
	 */
	public static function get_db_name()
	{
		//Return the db table name
		return "budget_request";
	}

	/**
	 *{@inheritdoc}
	 */	
	public static function get_db_index()
	{
		//Return the key of the db table's main index
		return "id";
	}
	
	/**
	 *{@inheritdoc}
	 */
	public static function get_class_var()
	{
		//Return a string of the name of the class that this manager uses
		return 'Request';
	}
}
//Try searching with this :D
//http://stackoverflow.com/questions/18415820/mysql-is-it-possible-to-use-like-on-all-columns-in-a-table
?>