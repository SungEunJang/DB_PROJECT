<?php
    #로그인이 되어있는지 확인하는 함수 is_login()을 사용하기 위해여 logincheck.php를 본 페이지에 포함시킨다.
    include("logincheck.php");

    if (is_login()){
        header("Location: main.php");   // 로그인이 되어으므로 index.php 페이지에 접속을 못하고 main.php로 바로 넘어간다.
    }else {
        ;                               // 로그인이 안 되어있으므로 아무것도 하지 않고 index.php에 머무른다.
    }

?>

<!DOCTYPE html>
<html>
    <meta charset="utf-8">
<head>
    <title></title>
</head>
<body>
    <h2>안녕하세요 평가했Sook 입니다.</h2>
    <form action="" method="post">
        <button type="submit" name="login">Sign in</button>
        <button type="submit" name="register">Sign up</button>
    </form>
</body>
</html>

<?php
    # Sign in 버튼을 눌렀다면 login.php 파일로 넘어간다.
    if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['login']) ) {
        echo "<script>location.href='login.php'</script>";
    }
    # Sign Up 버튼을 눌렀다면 authentication.php 파일로 넘어간다.
    else if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['register']) ) {
        echo "<script>location.href='authentication.php'</script>";
    }
?>