<?php
require_once( 'DBClass.php' );
class DBQuery extends DBClass
{

  function affectedRows()
	{
		return $this->link->affected_rows;
	}
  function state()
	{
		return $this->link->sqlstate;
	}

}

?>
