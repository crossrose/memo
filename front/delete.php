<!DOCTYPE html>
<html lang="ko">
<head>
    <meta http-equiv="Content-Script-Type" content="text/javascript">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DELETE MEMO</title>
    <script src="../js/jquery.min.js"></script>
</head>
<body>
<?php
  $error_message = "";

  if ( isset($_GET["idx"]) && $_GET["idx"] !='' && is_numeric($_GET["idx"]) ) {
    $idx = trim($_GET["idx"]);
  } else {
    $error_message = " 잘못된 접근입니다. ";
  }

  if ( isset($_GET["wherefrom"]) && $_GET["wherefrom"] !='' && is_numeric($_GET["wherefrom"]) ) {
      // wherefrom 인자 값 확인
      if (in_array($_GET["wherefrom"],array(1,2,3))) {
        $wherefrom = trim($_GET["wherefrom"]);
      } else {
        $error_message = " 잘못된 접근입니다. ";
      }
  } else {
    $error_message = " 잘못된 접근입니다. ";
  }

  // 문제가 발생시 리스트로 돌아간다.
  if ($error_message !="") {
    echo "<script type='text/javascript'>alert('".$error_message."'); top.location.href='main.php';</script>";
    exit;
  }

?>
  <script type="text/javascript">
  function chk_value()
  {
     if ($("#passwd").val() == "") {
       alert('비밀번호를 넣어주세요');
       return false;
     }else if ($("#passwd").val().length < 3 || $("#passwd").val().length > 13 ) {
       alert('비밀번호를 4자리 이상 , 12 자리 이하 넣어주세요');
       $("#passwd").val("");
       return false;
     }
  }

  function cancel()
  {
    //top.location.href =
    history.back();
    return false;
    // 기능 적으로는 스토리 보드 대로 (수정모드 -> 삭제 -> 취소 ->수정모드 , 목록-> 삭제-> 취소 -> 목록 ) 으로 되지만,
    // 올바른 방법인지에 대해서는 고민이 있음.
  }

  </script>
  <label> 삭제하시려면 비밀번호를 입력해 주셔야 합니다. </label>
  <form name="frmDeleteMemo" id="frmDeleteMemo" action="../modules/delete.php" method="post" onsubmit="return chk_value();">
    <input type="hidden" name="idx" id="idx" value="<?=$idx?>"/>
    <input type="hidden" name="wherefrom" id="wherefrom" value="<?=$wherefrom?>"/>
    <label>비밀번호</label><input type="password" id="passwd" name="passwd" /><br/>
    <input type="submit" value="삭제" />
    <input type="button" value="취소" onclick="cancel();" />
  </form>
</body>
</html>
