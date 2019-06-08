<?php
	include("dbcon.php");
	$usernick = $_SESSION['usernick'];
?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p> 정말 회원 탈퇴하시겠습니까? </p>
	<form action="" method="post">
		<button type="submit" name="stay">아니오. 돌아가겠습니다.</button>
		<button type="submit" name="leave">네 탈퇴하겠습니다.</button>
	</action>
</body>
</html>

<?php
	if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['leave']) ) {
		try {
			echo '<script>alert("성공적으로 탈퇴 되었습니다.");</script>';
			$stmt = $con->prepare("DELETE FROM SINFO WHERE SINFO_NICK = '$usernick'");
			$stmt->execute();
			unset($_SESSION['usernick']);
			header("Location: index.php");
		} catch(PDOException $e) {
	        die("Database error. " . $e->getMessage()); 
	    }
	} else if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['stay']) ) {
		header("Location: main.php");
	}
?>