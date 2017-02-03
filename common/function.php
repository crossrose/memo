<?php

	function check_value($value) {

		if ( !isset($value) ) {
			$return_value = "false";
		} else if ( $value == "" ) {
			$return_value = "false";
		} else {
			$return_value = trim($value);
		}
		return $return_value;
	}

	function check_value_skip($value,$check_item,$skip_items) {

		if ( !isset($value) ) {
			$return_value = "false";
		}else if (in_array($check_item,$skip_items)) {
			$return_value = trim($value);
		}else if ( $value == "" ) {
			$return_value = "false";
		}else {
			$return_value = trim($value);
		}
		return $return_value;
	}

	function passwd_encrypt($passwd){
		// 패스워드 암호화
		//http://php.net/manual/kr/function.password-hash.php
		//https://blog.asamaru.net/2016/03/03/php-password-hash-and-bcrypt/
		$return_value = password_hash($passwd,PASSWORD_DEFAULT);
		return $return_value;
	}

	function passwd_check($passwd,$org_passwd) {
		//http://php.net/manual/kr/function.password-verify.php
		//https://blog.asamaru.net/2016/03/03/php-password-hash-and-bcrypt/
		$return_value = password_verify($passwd,$org_passwd);
		return $return_value;
	}



	// 000 : IDX 값이 없습니다. MEMO가 존재하지 않거나 , MEMO가 삭제 되었습니다.
	// 001 : IDX 파라미터가 누락되었습니다. 비정상적인 접근입니다.
	// 002 : IDX 값의 범위를 넘었습니다. 비정상적인 접근입니다.
	// 100 : 해당 TYPE 값이 없습니다. 비정상적인 접근입니다.
	// 101 : TYPE 파라미더가 누락되었습니다. 비정상적인 접근입니다.
	// 201 : 이름이 누락 되었습니다.
	//
	// $error_code_list = {
	//      "000"->" MEMO가 존재하지 않거나 , MEMO가 삭제 되었습니다. "
	//     ,"001"->" 비정상적인 접근입니다. "
	//     ,"002"->" 비정상적인 접근입니다. "
	//     ,"100"->" 비정상적인 접근입니다. "
	//     ,"101"->" TYPE 파라미더가 누락되었습니다. 비정상적인 접근입니다."
	//     ,"201"->" 제목을 넣어주세요 "
	//     ,"202"->" 작성자명을 넣어주세요  "
	//     ,"203"->" 메모 내용을 넣어주세요 "
	//     ,"204"->" 비밀번호를 넣어주세요  "
	//   };

	// // common에 등록한 error code를 발생하기 위한 코드
	// list 처럼 체크하고 해당 값을 뽑아내는 방식)
	//	function get_error_code($error_code){
	//		if (in_array($error_code,$error_code_list))  {
	//			$return_value = $error_code_list['$error_code'];
	//		} else {
	//			$return_value = "undefined error";
	//		}
	//
	//    return $return_value;
	//  }

	// memo 상태값 에 따른 TRUE / FALSE 처리 예정
	//  function check_memo_status($value) {
	//    $memo_status = array{"NEW","EDIT","READ"};
	//    if ( in_array($value,$memo_status) ) {
	//      return TRUE;
	//    } else {
	//      return FALSE;
	//    }
	//  }

	//  메모 내용을 볼때 html 구문을 처리 하기 위한 function
	//  function check_textbox_value($value) {
	//
	//  }
?>
