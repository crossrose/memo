<?php

class CMySQLDB
{
	public function __construct(){
		$host='localhost';
		$user='memo_user';
		$passwd='memo!@#$';
		$database='db_memo';

		$this->cloneData = array();
		$this->connection = mysqli_connect($host, $user, $passwd, $database) or die("can't connect database");
	}


	function SetQuery($query)
	{
	//	$this->query	= preg_replace("/'/", "\\'", $query);
		mysqli_set_charset($this->connection,'utf8');
		$this->result	= mysqli_query($this->connection, $query);
		return $this->result;
	}

	function GetNumRows()
	{
		//mysqli_set_charset($this->connection,'utf8');
		$this->num_rows = mysqli_num_rows($this->result);
		$this->num_rows = $this->result->num_rows;
		return $this->num_rows;
	}

	function FetchData($cloned=0)
	{
		//mysqli_set_charset($this->connection,'utf8');
		$this->data	= mysqli_fetch_assoc($this->result);
		if (($cloned == 1) && ($this->data))
			$this->SetCloneData();
		return $this->data;
	}

	function FetchDataW($cloned=0)
	{
		//mysqli_set_charset($this->connection,'utf8');
		$this->data	= mysqli_fetch($this->result);
		if (($cloned == 1) && ($this->data))
			$this->SetCloneData();
		return $this->data;
	}

	function SetCloneData()
	{
		$this->cloneData[count($this->cloneData)] = $this->data;
	}

	function GetCloneData()
	{
		return $this->cloneData;
	}

	function DBclose()
	{
		return mysqli_close($this->connection);
	}

	function setChar(){
		return mysqli_set_charset($this->connection,'utf8');
	}

	function error(){
		$this->result	= mysqli_error($this->connection);
		return $this->result;
	}

  function GetLastIdx(){
     return mysql_insert_id($this->connection);
  }
}
?>
