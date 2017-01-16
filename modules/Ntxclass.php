<?php
// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

class Ntxclass {

  // public function NtxClass() {
  //
  // }

  public function __construct() {

  }

  public function __destruct() {

  }

  public function get_password($idx) {

    $db = new CMySQLDB();
    $query = sprintf("select passwd from memo where idx='%s'",$idx);
    $result = $db->SetQuery($query);
    $FetchData = $db->FetchData();
    $db->DBclose();
    $FetchData_result = $FetchData["passwd"];

    return $FetchData_result;
  }

  public function get_list() {

    $db = new CMySQLDB();
    $query = sprintf(" select idx,title,create_date,name,memo_link_url from memo order by idx desc ");
    $result = $db->SetQuery($query);

    $FetchData_result = $db->GetFetchDataMap();
    $db->DBclose();

    return $FetchData_result;
  }

  public function get_memos($idx) {

    $db = new CMySQLDB();
    $query  = sprintf( " select idx,title,name,memo,create_date,update_date,memo_link_url from memo where idx='%s' ",$idx);
    $result = $db->SetQuery($query);

    $FetchData_result = $db->FetchData();

    $db->DBclose();
    return $FetchData_result;
  }

  public function get_idx($idx) {

    $db = new CMySQLDB();
    $query = sprintf("select count(idx) from memo where idx='%s'",$idx);
    $db->SetQuery($query);

    $FetchData_result = $db->FetchData();

    $db->DBclose();
    return $FetchData_result;
  }
}

?>
