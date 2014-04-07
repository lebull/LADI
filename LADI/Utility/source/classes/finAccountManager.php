<?php 

/**
 *This file contains the definition of the FinAccountManager manager class.
 */

/**
 *@inheritdoc
 *
 *The FinAccountManager is responsible for handling anything that involves multiple Finance Accounts.  It should include things like getting multiple users from the database and displaying the users in a table format.
 */
class FinAccountManager extends DatabaseObjectManager{
	
	//Late static bindings
	//http://www.php.net/manual/en/language.oop5.late-static-bindings.php
	
	/**
	 *{@inheritdoc}
	 */
	public static function get_db_name()
	{
		return "budget_finAccount";
	}
	
	/**
	 *{@inheritdoc}
	 */
	public static function get_db_index()
	{
		return "id";
	}
	
	/**
	 *{@inheritdoc}
	 */
	public static function get_class_var()
	{
		return 'finAccount';
	}
}
//Try searching with this :D
//http://stackoverflow.com/questions/18415820/mysql-is-it-possible-to-use-like-on-all-columns-in-a-table
?>