<?php
// class가 PDO 형식이 아닌 단순 절차식 class 형식이므로,
// DB 객체가 한번 생성 하고 , 삭제 될때까지 하나의 데이터만 담고 있기 때문에
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
		mysqli_set_charset($this->connection,'utf8');
		$this->result	= mysqli_query($this->connection, $query);
		return $this->result;
	}

	function GetNumRows()
	{
		$this->num_rows = mysqli_num_rows($this->result);
		$this->num_rows = $this->result->num_rows;
		return $this->num_rows;
	}

	function FetchData($cloned=0)
	{
		$this->data	= mysqli_fetch_assoc($this->result);
		if (($cloned == 1) && ($this->data))
			$this->SetCloneData();
		return $this->data;
	}

	function FetchDataW($cloned=0)
	{
		$this->data	= mysqli_fetch_row($this->result);
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

	//http://www.w3schools.com/php/func_mysqli_fetch_row.asp
	// c# 의 dataSet, dataMap 처럼 전체 Row를 리턴 . 이렇게 되면, SQL 서버에 추가 쿼리 없이
	// dataMap 내에서의 연산이 가능 할 수 있을 듯 함
	// array_search , in_array 등을 통해서 sql 없이 search 등이 가능 할 듯 함
	// memory를 정리하는 방법은 리턴 받은 배열을 null로 처리하여 메모리 확보
	function GetFetchDataMap() {
		$this->data = array();

		while( $result_rows = mysqli_fetch_array($this->result,MYSQL_BOTH) ) {
			array_push($this->data,$result_rows);
		}
		return $this->data;
	}
}
?>
