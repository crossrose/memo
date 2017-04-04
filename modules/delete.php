<?php
	require (dirname(__FILE__). '/../db_conn.php');
	require (dirname(__FILE__). '/../common/_common.php');
	require (dirname(__FILE__). '/../common/function.php');
	require (dirname(__FILE__). '/../modules/Ntx.php');
	require (dirname(__FILE__). '/../modules/Tx.php');

	header("Content-Type: text/html;charset=UTF-8"); // 한글 처리용

	if($_SERVER["REQUEST_METHOD"] == "GET") {
		$error_message = "비정상적인 접근입니다.";
		header('Location: http://www.redwolf.site/memo/front/main.php');
		exit;
	}else {
		$parse = $_POST;
	}


	// referer 가 없는 경우 리턴 시켜야 함
	if (!isset($_SERVER["HTTP_REFERER"]))  {
		//messageBox_script("","main.php");
		toplocation_script("main.php");
		exit;
	}else if ( $_SERVER["HTTP_REFERER"] != "") {
		$referer = explode('/',explode('http://',$_SERVER["HTTP_REFERER"])[1]);
		print_r($referer);
		exit;

	}

	$array_posts = array("idx","passwd","wherefrom");
	$error_message = "";
	$sucess_message = "";

	foreach ( $array_posts as $arr ) {
		${$arr} = check_value($parse[$arr]);
		if ( ${$arr} == "false" ) {
			$chk_value = FALSE;
			$error_message = " 비정상적인 접근입니다. 1"; // IDX, PASSWORD , WHEREFROM 존재 확인
			// http://php.net/manual/kr/control-structures.break.php foreach 에 대한 break 문 처리
		} else {
			$chk_value = TRUE;
		}
	}

	if ( $chk_value ) {
		if ( strlen($passwd) < 4 || strlen($passwd) > 13 ) {
			$error_message = " 비밀번호를 4자리 이상 , 12 자리 이하 넣어주세요 ";
		} else if ( $wherefrom != 1 && $wherefrom != 2 ) {
			$error_message = " 비정상적인 접근 입니다.";
		} else {
			$ntx = new Ntx();
			$org_passwd = $ntx->get_password($idx); // 비밀번호 처리

			if ( passwd_check($passwd,$org_passwd) ) { // 비밀번호 확인

				$tx = new Tx();
				$result = $tx->set_memo_delete($idx);

				if ($result) $sucess_message = "삭제 되었습니다.";
				else $error_message = "삭제 실패 하였습니다. ";

			} else {
				$error_message = " 비밀번호가 틀렸습니다. ";
			}
		}
	}
	// wherefrom - 1: 목록 (read.php)
	//           - 2: 읽기 (main.php)
	if ( $error_message ) {
		if ($wherefrom == "2") { // 읽기 에서 삭제시
			echo '<script type="text/javascript">
				alert("'.$error_message.'");
				top.location.href="../front/read.php?idx='.$idx.'&wherefrom='.$wherefrom.'";
				</script>';
			exit;
		}else{ // $wherefrom 의 값이 2 이외에는 다 main으로 돌림  목록에서 삭제시
			messageBox_script($error_message,"../front/main.php");
			exit;
		}
	} else if ( $sucess_message ){ // 삭제하면 무조건 리스트로 돌아감
		// echo '<script type="text/javascript">
		// 	alert("'.$sucess_message.'");
		// 	top.location.href= "../front/main.php";
		// 	</script>';
		// exit;
		messageBox_script($sucess_message,"../front/main.php");
		exit;
	} else {
		// echo '<script type="text/javascript">
		// 	alert(" 비정상적인 접근 입니다.");
		// 	top.location.href= "../front/main.php";
		// 	</script>';
		// exit;
		$alert_massage = "비정상적인 접근 입니다.";
		messageBox_script($alert_massage,"../front/main.php");
		exit;
	}
?>
