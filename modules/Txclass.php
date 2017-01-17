<?php
class Tx {
	public function __construct() {
		// 생성자
	}

	public function __destruct() {
		// 소멸자
	}

	public function check_db_value($value,$db){
		if ( get_magic_quotes_gpc() ) {
			$value = mysqli_real_escape_string($db->connection,stripslashes(trim($value)));
		}else{
			$value = mysqli_real_escape_string($db->connection,trim($value));
		}
		return $value;
	}

	public function set_memo_insert($in_name,$in_title,$in_password,$in_memo,$in_memo_link_url) {
		$db = new CMySQLDB();

		$name		= $this->check_db_value($in_name,$db);
		$title		= $this->check_db_value($in_title,$db);
		$password	= $this->check_db_value($in_password,$db);
		$memo		= $this->check_db_value($in_memo,$db);
		$memo_link_url	= $this->check_db_value($in_memo_link_url,$db);

		$query = sprintf("insert into memo (name,title,passwd,memo,memo_link_url) values ('%s','%s','%s','%s','%s')",$name,$title,$password,$memo,$memo_link_url);
		$result = $db->SetQuery($query);

		$db->DBclose();
		return $result;
	}

	public function set_memo_update($idx, $in_name, $in_title,$in_memo, $in_memo_link_url) {

		$db = new CMySQLDB();

		$name		= $this->check_db_value($in_name,$db);
		$title		= $this->check_db_value($in_title,$db);
		$memo		= $this->check_db_value($in_memo,$db);
		$memo_link_url	= $this->check_db_value($in_memo_link_url,$db);

		$query = sprintf("update memo set name='%s', title='%s', memo='%s', memo_link_url='%s' where idx = '%s'",$name,$title,$memo,$memo_link_url,$idx);

		$result = $db->SetQuery($query);
		$db->DBclose();

		return $result;
	}

	public function set_memo_delete($idx) {

		$db = new CMySQLDB();
		$query = sprintf("delete from memo where idx = '%s'",$idx);

		$result = $db->SetQuery($query);
		$db->DBclose();

		return $result;
	}
}
?>
