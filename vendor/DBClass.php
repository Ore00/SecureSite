<?php
/********************************************************************************************/
/* DBClass created by Angelo Villegas [http://www.studiovillegas.com]						*/
/*																							*/
/* Copyright © Angelo Villegas																*/
/* Permission is hereby granted, free of charge, to any person obtaining a copy of this		*/
/* software and associated documentation files (the "Software"), to deal in the Software	*/
/* without restriction, including without limitation the rights to use, copy, modify,		*/
/* merge, publish, distribute, sublicense, and/or sell copies of the Software, and to		*/
/* permit persons to whom the Software is furnished to do so, subject to the following		*/
/* conditions:																				*/
/*																							*/
/* The above copyright notice and this permission notice shall be included in all copies	*/
/* or substantial portions of the Software.													*/
/*																							*/
/* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,		*/
/* INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A			*/
/* PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT		*/
/* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF		*/
/* CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE		*/
/* OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.											*/
/********************************************************************************************/
require_once( 'DBSettings.php' );

//Database class to connect to database and fire queries
class DBClass extends DatabaseSettings
{
	var $classQuery;
	var $link;

	var $errno = '';
	var $error = '';

	// Connects to the database
	function DBClass()
	{
		// Load settings from parent class
		$settings = DatabaseSettings::getSettings();

		// Get the main settings from the array we just loaded
		$host = $settings['dbhost'];
		$name = $settings['dbname'];
		$user = $settings['dbusername'];
		$pass = $settings['dbpassword'];

		// Connect to the database
		$this->link = new mysqli( $host , $user , $pass , $name );
	}

	// Executes a database query
	function query( $query )
	{
		$this->classQuery = $query;
		return $this->link->query( $query );
	}

	function escapeString( $query )
	{
		return $this->link->escape_string( $query );
	}

	// Get the data return int result
	function numRows( $result )
	{
		return $result->num_rows;
	}

	function lastInsertedID()
	{
		return $this->link->insert_id;
	}

	// Get query using assoc method
	function fetchAssoc( $result )
	{
		return $result->fetch_assoc();
	}

	// Gets array of query results
	function fetchArray( $result , $resultType = MYSQLI_ASSOC )
	{
		return $result->fetch_array( $resultType );
	}

	// Fetches all result rows as an associative array, a numeric array, or both
	function fetchAll( $result , $resultType = MYSQLI_ASSOC )
	{
			if(method_exists('mysqli_result', 'fetch_all')){
					return $result->fetch_all( $resultType );

				}else{
							 for ($res = array(); $tmp = $result->fetch_array($resultType);) $res[] = $tmp;
					 	 	return $res;
				}
	}

	// Get a result row as an enumerated array
	function fetchRow( $result )
	{
		return $result->fetch_row();
	}

	// Free all MySQL result memory
	function freeResult( $result )
	{
		//changed from $this->link->free_result( $result) because generated error
		$result->free();
	}

	//Closes the database connection
	function close()
	{
		$this->link->close();
	}

	function sql_error()
	{
		//if( empty( $error ) )
		if($this->link->connect_error)
		{
			// $errno = $this->link->errno;
			// $error = $this->link->error;
			$errno = $this->link->connect_errno;
			$error = $this->link->connect_error;
			return $errno . ' : ' . $error;
		}
		if($this->link->error != ""){
			$errno = $this->link->errno;
			$error = $this->link->error;
			return $errno . ' : ' . $error;
		}
		return false;
	}
}
?>
