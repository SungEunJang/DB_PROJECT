<?php
	include("dbcon.php");

	$username = $_SESSION['user_name'];
	$userssn  = $_SESSION['user_ssn'];
	$usermajor = $_SESSION['user_major'];
?>

<html>
<head>
	<meta charset="UTF-8">

	<h1>Register</h1>
</head>
<body>
	<h2>Sign Up :</h2>
	<form action ="" method ="post" >
		<p>
			<label for="name"class="floatLabel">Name</label>
			<br>
			<input id="name" name="name" type="text" value="<?php echo "$username"; ?>" readonly/>
		</p>

		<p>
			<label for="ssn"class="floatLabel">SSN (ID)</label>
			<br>
			<input id="ssn" name="ssn" type="text" value="<?php echo "$userssn"; ?>" readonly/>
		</p>

		<p>
			<label for="major"class="floatLabel">Major</label>
			<br>
			<input id="major" name="major" type="text" value="<?php echo "$usermajor"; ?>" readonly/>
		</p>

		<p>
			<label for="password"class="floatLabel">Password</label>
			<br>
			<input id="password" name="password" type="password" required/>
		</p>

		<p>
			<label for="passconfirm"class="floatLabel">Repeat Password</label>
			<br>
			<input id="passconfirm" name="passconfirm" type="password" required/>
		</p>

		<p>
			<label for="email"class="floatLabel">Email</label>
			<br>
			<input id="email" name="email" type="email" required/>
		</p>

		<p>
			<label for="nick"class="floatLabel">Nickname</label>
			<br>
			<input id="nick" name="nick" type="text" required/>
		</p>

		<button type="submit" name="signup">Create My Account</button>
	</form>
</body>
</html>

<?php
	

	if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['signup']) ) {
		
		$sinfo_name = $_SESSION['user_name'];
		$sinfo_ssn  = $_SESSION['user_ssn'];
		$sinfo_major = $_SESSION['user_major'];

		$sinfo_pass = $_POST['password'];
		$pwconfirm = $_POST['passconfirm'];
		$sinfo_mail = $_POST['email'];
		$sinfo_nick = $_POST['nick'];

		if (strlen($_POST['password']) < 5)
			echo "<script>alert('Your passwords is too short'); history.back();</script>";
		else if ($_POST['password'] != $_POST['passconfirm'])
			echo "<script>alert('Your passwords do not match'); history.back();</script>";
		else {
	
			try {

				$st_mt = $con->prepare("SELECT sinfo_nick FROM SINFO WHERE sinfo_nick = '$sinfo_nick'");
				$st_mt->bindparam(':sinfo_nick', $sinfo_nick);
				$st_mt->execute();
				$row = $st_mt->fetch();
				$is_nick_exists = $row['sinfo_nick'];

				if ($is_nick_exists)
					echo "<script>alert('$sinfo_nick Already exists. Try another nickname');</script>";
				else {

					$stmt = $con->prepare(
						'INSERT INTO SINFO(sinfo_name, sinfo_ssn, sinfo_major, sinfo_pass, sinfo_mail, sinfo_nick) 
						VALUES(:sinfo_name, :sinfo_ssn, :sinfo_major, :sinfo_pass, :sinfo_mail, :sinfo_nick)'
					);

					$stmt->bindparam(':sinfo_name', $sinfo_name);
					$stmt->bindparam(':sinfo_ssn', $sinfo_ssn);
					$stmt->bindparam(':sinfo_major', $sinfo_major);
					$stmt->bindparam(':sinfo_pass', $sinfo_pass);
					$stmt->bindparam(':sinfo_mail', $sinfo_mail);
					$stmt->bindparam(':sinfo_nick', $sinfo_nick);

					if ($stmt->execute()) {
						unset($_SESSION['user_name']);
						unset($_SESSION['user_major']);
						unset($_SESSION['user_ssn']);
						echo '<script>alert("Registration Success!");</script>';
						echo "<script>location.href='index.php'</script>";
					}
					else {
						echo '<script>alert("Err");</script>';
					}
				}

			} catch(PDOException $e) {
	            die("Database error: " . $e->getMessage()); 
	        }

    	}
	}
?>