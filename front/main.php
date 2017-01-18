<?php
	require (dirname(__FILE__) . '/../db_conn.php');
	require (dirname(__FILE__) . '/../common/_common.php');
	require (dirname(__FILE__) . '/../modules/Ntx.php');
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>MEMO PAPER</title>
	<script src="../js/jquery.min.js"></script>
</head>
<body>
	<table border="1">
		<thead>
			<tr>
				<td> 번호 </td>
				<td> 제목 </td>
				<td> 등록일자 </td>
				<td> 작성자 </td>
				<td colspan="2"> 편집 </td>
			</tr>
		</thead>
		<tbody>
  <?php
	$ntx = new Ntx();
	$memo_list = $ntx->get_list();
	$memo_list_idx = count($memo_list);

    //from where : 1 - LIST
    //from where : 2 - READ
    //from where : 3 - EDIT

	for ( $i=0 ; $i<count($memo_list) ; $i++ ) {
		echo "<tr>";
			echo "<td>".$memo_list_idx--."</td> ";
			echo "<td><a href='read.php?idx=".$memo_list[$i]["idx"]."'>".htmlspecialchars($memo_list[$i]["title"])."</a></td> ";
			echo "<td>".$memo_list[$i]["create_date"]."</td> ";
			echo "<td>".$memo_list[$i]["name"]."</td> ";
			echo "<td><a href='delete.php?idx=".$memo_list[$i]["idx"]."&wherefrom=1'>삭제하기</a></td> ";
			echo "<td><a href='regist.php?idx=".$memo_list[$i]["idx"]."&memo_type=1&wherefrom=1'>수정하기</a></td>";
		echo "</tr>";
	}
	?>
		</tbody>
	</table>
	<label><a href="regist.php">글쓰기</a></label>
</body>
</html>
