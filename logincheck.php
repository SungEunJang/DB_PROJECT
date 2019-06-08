<?php
# 사용자가 로그인이 되어있는지 체크하는 php 파일입니다.
#is_login() 의 return 값이 true면 로그인 된 상태, false면 로그인 안 되어있는 상태
    function is_login(){

    	#localhost에 접속해있는 상태에서 'usernick'이라는 SESSION이 설정되어 있다면 login.php 에서 로그인이 성공한 상태
        if (isset($_SESSION['usernick'])) {
            return true;  // 로그인 된 상태
        } else {
            return false; // 로그인 안된 상태
        }
    }
?>