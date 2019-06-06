<?php
    include("logincheck.php");

    if (is_login()){
        ;
    }else {
        echo "<script>location.href='main.php'</script>";
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
    if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['login']) ) {
        echo "<script>location.href='login.php'</script>";
    }
    else if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['register']) ) {
        echo "<script>location.href='authentication.php'</script>";
    }
?>