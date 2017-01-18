<?php
	require (dirname(__FILE__). '/../db_conn.php');
	require (dirname(__FILE__). '/../common/function.php');
	require (dirname(__FILE__). '/../modules/Ntx.php');
	require (dirname(__FILE__). '/../modules/Tx.php');

	header("Content-Type: text/html;charset=UTF-8"); // 한글 처리용

	if($_SERVER["REQUEST_METHOD"] == "GET") {
		$error_message = "비정상적인 접근입니다.";
		header('Location: http://www.bloodredwolves.com/memo/front/main.php');
		exit;
	}else {
		$parse = $_POST;
	}

	$array_posts		= array("memo_title","memo_text","memo_name","memo_passwd","memo_link_url","idx","memo_type","wherefrom");
	$array_skip_posts	= array("idx","memo_type","wherefrom");

	$result			= 0;
	$error_message	= "";
	$sucess_message = "";
	$chk_value		= TRUE;

	// 수정모드 였을때는 입력 하던 창 혹은 READ 로 돌아가야함
	// 등록모드 였을때는 입력 하던 창 혹은 목록으로 돌아가야함

	// if ( !isset($parse["memo_title"]) && $parse["memo_title"] == "" ) {
	// 	$error_message = "메모 제목을 넣어 주세요"
	// 	header("Location : ".dirname(__FILE__)."/../front/"
	// } else {
	// 	$memo_title = trim($parse["memo_title"]);
	// }
	//
	// if ( !isset($parse["memo_text"]) && $parse["memo_text"] == "") {
	// 	$error_message = "메모 내용을 넣어주세요 ";
	// 	header("Location : ".dirname(__FILE__)."/../front/"
	// } else {
	// 	$memo_text = trim($parse["memo_title"]);
	// }
	//
	// if ( !isset($parse["memo_name"]) && $parse["memo_name"] == "") {
	// 	$error_message = "메모 작성자가 ";
	// 	header("Location : ".dirname(__FILE__)."/../front/"
	// } else {
	// 	$memo_text = trim($parse["memo_title"]);
	// }


	// // loop 를 계속 돌리라...
	foreach ($array_posts as $arr) {
		//${$arr} = check_value_skip($parse[$arr],$arr,$array_skip_posts);

		if ( isset($parse[$arr]) && $parse[$arr] != "" ) {
			${$arr} = trim($parse[$arr]);
		}else if (in_array($arr,$array_skip_posts)) {
			${$arr} = trim($parse[$arr]);
		}else {
			$chk_value = FALSE;
			// 첫번째 걸리는 것만 check 해서 error_message 로 전송함
			// 근데 이렇게 하면 의미 없는 loop를 도는 것인데 ... 만약 첫번째 item 에서 문제가 발생하면
			// 나머지 아이템은 의미 없는 loop 와 변수 할당을 해야 하는데, 그게 break를 걸어서 즉시 처리하는 것 보다 나은 거라는 건가?
			// 반복을 적게 하는 것이 좋은데, 왜 이렇게 해야 하는 거지 ? 만약 loop 도는 변수가 많고 에러가 처음에 나타나면 ,
			// 최종 변수까지 처리 후에 error 처리가 되는데 ... 이걸 감수하는 로직을 짜라는 것인가.
			//
			if ($arr == "memo_title") 		$error_message = "메모 제목을 넣어주세요 ";
			elseif ($arr == "memo_text")	$error_message = "메모 내용을 넣어주세요";
			elseif ($arr == "memo_name")	$error_message = "등록자 이름을 넣어주세요";
			elseif ($arr == "memo_passwd")	$error_message = "비밀번호를 넣어주세요";
			elseif ($arr == "memo_link_url") $error_message = "Link URL을 넣어주세요";
			else $error_message = "비정상적인 접근입니다.";

			echo '<script type="text/javascript">
					alert("'.$error_message.'");
					</script>';

			header('Location: http://www.bloodredwolves.com/memo/front/main.php');
			exit;
		}
	}

	//break 문 없이 처리 하게 됨
	// foreach ( $array_posts as $arr ) {
	//
	// 	${$arr} = check_value_skip($parse[$arr],$arr,$array_skip_posts);
	//
	// 	if ( ${$arr} == "false" )  {
	// 		$chk_value = FALSE; // PHP 에서는 swich case break 문을 지양한다
	//
	// 		if ($arr == "memo_title") 		$error_message = "메모 제목을 넣어주세요 ";
	// 		elseif ($arr == "memo_text")	$error_message = "메모 내용을 넣어주세요";
	// 		elseif ($arr == "memo_name")	$error_message = "등록자 이름을 넣어주세요";
	// 		elseif ($arr == "memo_passwd")	$error_message = "비밀번호를 넣어주세요";
	// 		elseif ($arr == "memo_link_url") $error_message = "Link URL을 넣어주세요";
	// 		else $error_message = "비정상적인 접근입니다.";
	// 		// http://php.net/manual/kr/control-structures.break.php foreach 에 대한 break 문 처리
	// 		break; // 어떤 상황이라도 error 가 발생하면 그 즉시 foreach 를 벗어 나야 함 따라서 break 문은 필수임
	// 	} else {
	// 		$chk_value = TRUE;
	// 	}
	// }


	if ( $chk_value ) {
		if ( $memo_type == "1" ) {
			if ( strlen($memo_passwd) < 4 || strlen($memo_passwd) > 13 ) {
				$error_message = " 비밀번호를 4자리 이상 , 12 자리 이하 넣어주세요 ";
			}else if ( $wherefrom != "1" && $wherefrom != "2" ) { //wherefrom  조건 추가
				$error_message = "비정상적인 접근입니다.";
			}else{
				$ntx = new Ntx();
				$org_passwd = $ntx->get_password($idx);
				// 비밀번호 확인
				if ( passwd_check($memo_passwd,$org_passwd) ) {
					$tx = new Tx(); // password 는 업데이트 하지 않음
					$result = $tx->set_memo_update($idx,$memo_name,$memo_title,$memo_text,$memo_link_url);
					if ( $result ) $sucess_message = " 수정 되었습니다. ";
					else $error_message = " 수정 실패 하였습니다. ";
				} else {
					$error_message = " 비밀번호가 틀렸습니다. ";
				}
			}
		} else {
			$tx = new Tx();
			$result = $tx->set_memo_insert($memo_name,$memo_title,passwd_encrypt($memo_passwd),$memo_text,$memo_link_url);
			if ( $result ) $sucess_message = " 등록 되었습니다.";
			else $error_message = " 등록 실패 하였습니다. ";
		}
	}else{

	}


	// 밑에 코드는 그냥 만든 거임 . 어떻게 , 제대로는 아님
	// 어떻게 해야 제대로 만드는 가
	// $error_message = "에러";

	// 수정모드든 등록모드든 에러가 발생하면, 전 단계로 돌아가면 됨. main으로 돌아가는 케이스는 인자 값이 정상적이지 않을 경우에만 돌아가면 됨
	if ($error_message) {
		if ( $wherefrom != "1" && $wherefrom != "2" ) {  // 목록에서 들어와서 문제가 생기면 , 수정하던 상황으로 돌아간다.
			echo '<script type="text/javascript">alert("'.$error_message.'");top.location.href= "../front/main.php";</script>';
		}else {
			echo '<script type="text/javascript">alert("'.$error_message.'");history.back();</script>';
			exit;
		}
	}else if ($sucess_message) {
		if ($wherefrom == "2") { // 읽기에서 들어오면
			echo '<script type="text/javascript">alert("'.$sucess_message.'");top.location.href= "../front/read.php?idx='.$idx.'";</script>';
			exit;
		} else {
			echo '<script type="text/javascript">alert("'.$sucess_message.'");top.location.href= "../front/main.php";</script>';
			exit;
		}
	}else{ // 그외의 문제가 발생하거나, 특이 사항 발생시에는 무조건 main으로 돌아간다. - 보험
		$error_message = "정의하지 않은 에러가 발생했습니다. ";
		echo '<script type="text/javascript">alert("'.$error_message.'");top.location.href= "../front/main.php";</script>';
		exit;
	}
?>
