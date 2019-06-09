<?php
	include("dbcon.php");
	include("logincheck.php");
	if (is_login()) {
		$usernick = $_SESSION['usernick'];
		try {
			$stmt = $con->prepare("SELECT * FROM SINFO WHERE SINFO_NICK = '$usernick'");
			$stmt->execute();
		} catch (PDOException $e) {
			die("Database error. " . $e->getMessage()); 
		}

		$row = $stmt->fetch();
		$username = $row['SINFO_NAME'];
		$usermajor = $row['SINFO_MAJOR'];
		$userssn = $row['SINFO_SSN'];
		$useremail = $row['SINFO_MAIL'];
	} else {
		header("Location: index.php");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
    #topMenu { 
        height: 30px;
        width: 850px;
    }
    #topMenu ul li { 
        list-style: none; 
        color: white;
        background-color: #2d2d2d; 
        float: left;
        line-height: 30px;
        vertical-align: middle; 
        text-align: center;
    }
     #topMenu .menuLink {
        text-decoration:none;
        color: white;
        display: block;
        width: 150px;
        font-size: 12px; 
        font-weight: bold;
        font-family: "Trebuchet MS", Dotum, Arial;
    } 
    #topMenu .menuLink:hover { 
    color: red;
    background-color: #4d4d4d;
    }

    #left_banner {   
        position: fixed;
        float:left;
        width:400;
        height:400px;
        margin-left:-500px;
        top:140px;
        left:35%;
        background-color:#ccff33;
    }

    #right_list {
        position: relative;
        margin-right: -200px;
        right:-40%;
    }

    </style>
    
	<title></title>
	<div class="menubar">
        <nav id="topMenu">
            <ul>
                <li><a class="menuLink" href="main.php">강의평가</a></li>
                <li><a class="menuLink" href="recommendation.php">강의추천</a></li>
                <li><a class="menuLink" href="qtest.php">Q&A</a></li>
                <li><a class="menuLink" href="logout.php">로그아웃</a></li>
                <li><a class="menuLink" href="leaveaccount.php">회원탈퇴</a></li>
                <li><a class="menuLink" href="updateinfo.php">정보수정</a></li>
            </ul>
        </nav>
    </div>
</head>
<body>
	<br>
	<h1> 회원 정보 수정 </h1>
	<form action="" method="post">
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
			<label for="nick"class="floatLabel">Nickname</label>
			<br>
			<input id="nick" name="nick" type="text" value="<?php echo $usernick; ?>" required/>
		</p>

		<p>
			<label for="email"class="floatLabel">Email</label>
			<br>
			<input id="email" name="email" type="email" value="<?php echo $useremail; ?>" required/>
		</p>


		<button type="submit" name="update">Update My Account</button>
	</form>
</body>
</html>

<?php
	if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['update']) ) {

		$sinfo_nick = $_POST['nick'];
		$sinfo_pass = $_POST['password'];
		$pwconfirm = $_POST['passconfirm'];	
		$sinfo_mail = $_POST['email'];

		if ($_POST['password'] != $_POST['passconfirm'])
			echo "<script>alert('Your passwords do not match'); history.back();</script>";
		else if (strlen($_POST['password']) < 5)
			echo "<script>alert('Your passwords is too short'); history.back();</script>";
		else {
			try {
				$st_mt = $con->prepare("SELECT sinfo_nick FROM SINFO WHERE sinfo_nick = '$sinfo_nick'");
				$st_mt->bindparam(':sinfo_nick', $sinfo_nick);
				$st_mt->execute();

				$row = $st_mt->fetch();
				$is_nick_exists = $row['sinfo_nick'];

				if ($is_nick_exists && $is_nick_exists != $usernick)
					echo "<script>alert('$sinfo_nick Already exists. Try another nickname');</script>";
				else {
					$stmt_update = $con->prepare("UPDATE SINFO 
												SET SINFO_NICK = '$sinfo_nick', SINFO_PASS = '$sinfo_pass', SINFO_MAIL = '$sinfo_mail' 
												WHERE SINFO_SSN = '$userssn'");
					if ($stmt_update->execute()) {

						echo "<script> alert('성공적으로 수정되었습니다.'); </script>";
						header("Location: main.php");
					}
				}
			} catch (PDOException $e) {
				die("Database error. " . $e->getMessage()); 
			}			
		}
	}
?>