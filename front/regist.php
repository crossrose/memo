<?php
  require (dirname(__FILE__) . '/../db_conn.php');
  require (dirname(__FILE__) . '/../common/_common.php');
  require (dirname(__FILE__) . '/../modules/Ntxclass.php');

  $error_message = "";
  $memo_type = "0";
  $idx    = -1;
  $name   = "";
  $title  = "";
  $memo   = "";
  $create_date = "";
  $memo_link_url = "";
  $button_value = "등록";
  $wherefrom = "0";

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta http-equiv="Content-Script-Type" content="text/javascript">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EDIT MEMO</title>
    <script src="../js/jquery.min.js"></script>
</head>
<body>
<?php
  // 1. 인자값 check
  // 2.
  if  ( isset($_GET["memo_type"]) && $_GET["memo_type"] !='' && is_numeric($_GET["memo_type"]) ) {
    //

    if ( isset($_GET["wherefrom"]) && $_GET["wherefrom"] !='' && is_numeric($_GET["wherefrom"]) ) {
       if ( in_array($_GET["wherefrom"],array(1,2) ) ) {
         $wherefrom = trim($_GET["wherefrom"]);
       }else{
         $error_message = " 잘못된 접근입니다 " ;
       }
    }

     $memo_type     = trim($_GET["memo_type"]);
    //memo type : 0 - 쓰기 - NEW
    //memo type : 1 - 수정 - EDIT
    //memo type : 2 - 삭제 - DELETE

    //from where : 1 - LIST
    //from where : 2 - READ

    // 현재는 수정이 아니면, 등록으로 생각한다. get check
    if ( $memo_type == "1" ) {
      if  ( isset($_GET["idx"]) && $_GET["idx"] !='' && is_numeric($_GET["idx"]) ) {

        $idx = trim($_GET["idx"]);

        $db  = new CMySQLDB();
        $ntx = new NtxClass();
        $memo_list = $ntx->get_memos($idx);

        if ( count($memo_list) > 0 ) {
          $name   = $memo_list["name"];
          $title  = $memo_list["title"];
          $memo   = $memo_list["memo"];

          $create_date   = $memo_list["create_date"];
          $memo_link_url = $memo_list["memo_link_url"];
          $button_value  = "수정";

        } else {
           $error_message = " 해당 메모가 존재 하지 않거나, 삭제 되었습니다. ";
        }
        $db->DBclose();

      } else {
        $error_message = " 잘못된 접근입니다. ";
      }
    }
  }

  if ($error_message !="") {
   echo "<script type='text/javascript'>alert('".$error_message."'); top.location.href='main.php';</script>";
   exit;
  }

?>
  <script type="text/javascript">
  function chk_value()
  {
    if ($("#memo_title").val() == "") {
       alert('제목을 넣어주세요');
       return false;
     }

     if ($("#memo_text").val() == "") {
       alert('내용을 넣어주세요');
       return false;
     }

     if ($("#memo_name").val() == "") {
       alert('이름을 넣어주세요');
       return false;
     }

     if ($("#memo_passwd").val() == "") {
       alert('비밀번호를 넣어주세요');
       return false;
     }else if ($("#memo_passwd").val().length < 3 || $("#memo_passwd").val().length > 13 ){
       alert('비밀번호를 4자리 이상 넣어주세요');
       $("#memo_passwd").val('');
       return false;
     }

     if ($("#memo_link_url").val() == "") {
       alert('URL을 넣어주세요');
       return false;
     }
  }

  function cancel(wherefrom,idx)
  {
    if (wherefrom == "2" ) {
      //top.location.href= history.back(-1);
      top.location.href= "read.php?idx="+idx;
      return false;
    }else{
      top.location.href= "main.php";
      return false;
    }
  }
  </script>
  <form name="frmEditMemo" id="frmEditMemo" action="../modules/regist.php" method="post" onsubmit="return chk_value();">
    <!-- return javascript function 을 해야 이중 submit 이 되지 않음 -->
    <input type="hidden" name="idx" id="idx" value="<?=$idx?>"/>
    <input type="hidden" name="memo_type" id="memo_type" value="<?=$memo_type?>"/>
    <input type="hidden" name="wherefrom" id="wherefrom" value="<?=$wherefrom?>"/>
    <table>
      <tr>
        <td><label>제목</label></td>
        <td><input type="text" id="memo_title" name="memo_title" value="<?=$title?>"/></td>
      </tr>
      <tr>
        <td><label>메모내용</label></td>
        <td><textarea id="memo_text" name="memo_text" cols="50" rows="30"><?=$memo?></textarea></td>
      </tr>
      <tr>
        <td><label>작성자</label></td>
        <td><input type="text" id="memo_name" name="memo_name" value="<?=$name?>"/></td>
      </tr>
      <tr>
        <td><label>비밀번호</label></td>
        <td><input type="password" id="memo_passwd" name="memo_passwd" /></td>
      </tr>
      <tr>
        <td><label>연결 URL</label></td>
        <td><input type="text" id="memo_link_url" name="memo_link_url" value="<?=$memo_link_url?>"/></td>
      </tr>
<?php if ($create_date !="") { ?>
      <tr>
        <td><label>작성일자</label></td><td><?=$create_date?></td>
      </tr>
<? } ?>
      <tr>
        <td><input type="submit" value="<?=$button_value?>" /></td>
        <td><input type="button" value="취소" onclick="cancel(<?=$wherefrom?>,<?=$idx?>);" /></td>
      </tr>
    </table>
  </form>
</body>
</html>
