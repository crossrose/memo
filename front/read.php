<?php
	require (dirname(__FILE__) . '/../db_conn.php');
	require (dirname(__FILE__) . '/../common/_common.php');
	require (dirname(__FILE__) . '/../modules/NtxClass.php');

	$error_message = "";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>READ MEMO</title>
	<script src="../js/jquery.min.js"></script>
</head>
<body>
<?php

	if ( isset($_GET["idx"]) && $_GET["idx"] !='' && is_numeric($_GET["idx"]) ) {

		$idx = trim($_GET["idx"]);
		$ntx = new ntxClass();
		$memo_list = $ntx->get_memos($idx);

		if ( count($memo_list) > 0 ) {
			$title  = htmlspecialchars($memo_list["title"]);
			$name   = $memo_list["name"];
			$memo   = nl2br(htmlspecialchars($memo_list["memo"]));
			$create_date = $memo_list["create_date"];
			$memo_link_url = $memo_list["memo_link_url"];
		} else {
			$error_message = " 해당 메모가 존재 하지 않거나, 삭제 되었습니다. ";
		}
	} else {
		$error_message = " 잘못된 접근입니다.";
	}

	if ($error_message !="") {
		echo "<script type='text/javascript'>alert('".$error_message."'); top.location.href='main.php';</script>";
		exit;
	}
?>
	<table border="1">
		<tr>
			<td><label>제목</label></td>
			<td colspan="2"><?=$title?></td>
		</tr>
		<tr>
			<td><label>메모내용</label></td>
			<td colspan="2"><?=$memo?></td>
		</tr>
		<tr>
			<td><label>작성자</label></td>
			<td colspan="2"><?=$name?></td>
		</tr>
		<tr>
			<td><label>URL</label></td>
			<td colspan="2"><?=$memo_link_url?></td>
		</tr>
		<tr>
			<td><label>작성일자</label></td>
			<td colspan="2"><?=$create_date?></td>
		</tr>
		<tr>
			<td><input type="button" value="수정하기" onclick="location.href='regist.php?idx=<?=$idx?>&memo_type=1&wherefrom=2'"/></td>
			<td><input type="button" value="삭제하기" onclick="location.href='delete.php?idx=<?=$idx?>&wherefrom=2'"/></td>
			<td><input type="button" value="목록으로" onclick="location.href='main.php'"/></td>
		</tr>
	</table>
</body>
</html>
