<!DOCTYPE html>
<html>
	<meta charset="utf-8">
	<h1>Sign in</h1>
<head>
	<title></title>
</head>
<body>
	<form action="" method="post">
		<p>
			<label for="id"class="floatLabel">ID (Your SSN)</label>
			<br>
			<input id="userid" name="userid" type="text" required/>
		</p>
		<p>
			<label for="password"class="floatLabel">Password</label>
			<br>
			<input id="userpw" name="userpw" type="password" required/>
		</p>
		<button type="submit" name="signin">Sign in</button>
	</form>
</body>
</html>

<?php
	include("dbcon.php");

	if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['signin']) ) {
		$userid = $_POST['userid'];
		$userpw = $_POST['userpw'];

		try { 
				$stmt = $con->prepare("SELECT sinfo_ssn, sinfo_pass, sinfo_nick FROM SINFO WHERE SINFO_SSN = '$userid'");
				$stmt->bindParam(':sinfo_ssn', $userid);
				$stmt->execute();
		} catch(PDOException $e) {
			die("Database error. " . $e->getMessage()); 
		}

		$row = $stmt->fetch();
		$password = $row['sinfo_pass'];

		if ($row) {
			if ($password == $userpw) {
				$usernick = $row['sinfo_nick'];
				$_SESSION['usernick'] = $usernick;
				echo "<script>alert('Welcome $usernick!');</script>";
				echo "<script>location.href='main.php'</script>";
			}
			else {
				echo "<script>alert('Wrong Password. Please Try Agian.'); history.back(); </script>";
			}
		}
		else {
			echo "<script>alert('You are not a memeber. Please Sign Up.');</script>";
		}
	}
?>