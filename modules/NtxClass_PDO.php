<?php
class NtxClass {

  //private $db = new PDO('mysql:host=localhost;dbname=testdb;charset=utf8', 'username', 'password');


  private $db = "";

  public function NtxClass(PDO $in_db ) {
    $this->db = $in_db;
  }

  public function __construct() {

  }

  public function __destruct() {

  }

  public function get_password($idx) {

    $query = sprintf(" select passwd from memo where idx='%s' ",$idx);
    $result = $this->$db->query($query);

    $FetchData_result = $db->FetchData();

    return $FetchData_result;
  }

  public function get_list() {


    $query = sprintf(" select idx,title,create_date,name from memo order by idx desc ");
    //$db->SetQuery($query);

    // array_push 는 push 받는 쪽이 array() 여야 한다.
    // 선언하지 않으면 Exception 발생함 -> 리스트가 나오지 않음
    //PHP Warning:  array_push() expects parameter 1 to be array, null given in /var/www/html/memo/modules/NtxClass.php on line 33, referer: http://www.bloodredwolves.com/memo/modules/regist.php

    $FetchData_result =  array();
    while ( $FetchData = $db->FetchData() ) {
        array_push($FetchData_result,$FetchData);
    }

    $db->DBclose();

    return $FetchData_result;
  }

  public function get_memos($idx) {

    //$db = new CMySQLDB();
    $query  = sprintf( " select idx,title,name,memo,create_date,update_date from memo where idx='%s' ",$idx);
    $result = $db->SetQuery($query);

    $FetchData_result = $db->FetchData();

    //$db->DBclose();
    return $FetchData_result;
  }

  public function get_idx($idx) {

    //$db = new CMySQLDB();
    $query = sprintf(" select count(idx) from memo where idx='%s' ",$idx);
    $db->SetQuery($query);

    $FetchData_result = $db->FetchData();

    //$db->DBclose();
    return $FetchData_result;
  }
}

?>
