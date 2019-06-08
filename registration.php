<!-- 
    본 파일인 registration.php는 숙명여대 학생인지 인증이 되었으면 회원가입을 진행하는 페이지입니다.
    사용자의 이름, 학번, 전공 정보는 authentication.php에서 작성한 값을 SESSION으로 넘겨 받아옵니다.
    그리고 사용자가 나머지 이메일, 닉네임, 비밀번호를 입력하면 이를 회원정보 테이블인 SINFO 테이블에 insert합니다.
-->	

<?php
	#로그인이 되어있는지 확인하는 함수 is_login()을 사용하기 위해여 logincheck.php를 본 페이지에 포함시킨다.
	include("logincheck.php");

    if (is_login()) {
    	header("Location: main.php");		// 로그인이 되어있으므로 registration.php 페이지에 접속을 못하고 main.php로 바로 넘어간다.
    } else {								// 로그인이 되어있지 않으므로
        include("dbcon.php");				// mysql의 DB와 연결을 설정해놓은 파일인 dbcon.php를 본 페이지에 포함시킨다.
        // authentication.php에서 설정한 username, user_ssn, user_major에 대한 정보를 SESSION으로 받아온다.
        $username = $_SESSION['user_name']; 
		$userssn  = $_SESSION['user_ssn'];
		$usermajor = $_SESSION['user_major'];
    }
?>

<html>
<head>
	<meta charset="UTF-8">

	<h1>Register</h1>
</head>
<body>
	<h2ㄱ>Sign Up :</h2>
	<form action ="" method ="post">
		<p>
			<label for="name"class="floatLabel">Name</label>
			<br>
			<!-- 이름 : session으로 넘겨받은 값이므로 php로 value 고정, 변경할 수 없도록 readonly -->
			<input id="name" name="name" type="text" value="<?php echo "$username"; ?>" readonly/>	
		</p>

		<p>
			<label for="ssn"class="floatLabel">SSN (ID)</label>
			<br>
			<!-- 학번 : session으로 넘겨받은 값이므로 php로 value 고정, 변경할 수 없도록 readonly -->
			<input id="ssn" name="ssn" type="text" value="<?php echo "$userssn"; ?>" readonly/>
		</p>

		<p>
			<label for="major"class="floatLabel">Major</label>
			<br>
			<!-- 전공 : session으로 넘겨받은 값이므로 php로 value 고정, 변경할 수 없도록 readonly -->
			<input id="major" name="major" type="text" value="<?php echo "$usermajor"; ?>" readonly/>
		</p>

		<p>
			<label for="password"class="floatLabel">Password</label>
			<br>
			<!-- 비밀번호 입력 : 필수로 입력하도록 reauired -->
			<input id="password" name="password" type="password" required/>
		</p>

		<p>
			<label for="passconfirm"class="floatLabel">Repeat Password</label>
			<br>
			<!-- 비밀번호 재입력 : 필수로 입력하도록 reauired -->
			<input id="passconfirm" name="passconfirm" type="password" required/>
		</p>

		<p>
			<label for="email"class="floatLabel">Email</label>
			<br>
			<!-- 이메일 입력 : 필수로 입력하도록 reauired -->
			<input id="email" name="email" type="email" required/>
		</p>

		<p>
			<label for="nick"class="floatLabel">Nickname</label>
			<br>
			<!-- 닉네임 입력 : 필수로 입력하도록 reauired -->
			<input id="nick" name="nick" type="text" required/>
		</p>

		<button type="submit" name="signup">Create My Account</button>
	</form>
</body>
</html>

<?php
	
	# post method로 signup이라는 버튼(submit)이 눌린다면
	if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['signup']) ) {
		
		$sinfo_name = $_SESSION['user_name'];		# sinfo_name : session으로 받은 user_name
		$sinfo_ssn  = $_SESSION['user_ssn'];		# sinfo_ssn : session으로 받은 user_ssn
		$sinfo_major = $_SESSION['user_major'];		# sinfo_major : session으로 받은 user_major

		$sinfo_pass = $_POST['password'];			# sinfo_pass : name='password'인 input에 사용자가 입력한 값 = 비밀번호
		$pwconfirm = $_POST['passconfirm'];			# pwconfirm : name='passconfirm'인 input에 사용자가 입력한 값 = 비밀번호 재입력
		$sinfo_mail = $_POST['email'];				# sinfo_email : name='email'인 input에 사용자가 입력한 값 = 이메일
		$sinfo_nick = $_POST['nick'];				# sinfo_nick : name='nick'인 input에 사용자가 입력한 값 = 닉네임

		# 만약 입력한 비밀번호 값이 5글자보다 짧다면 경고 알림창이 뜨고 다시 재입력하도록 registration.php로 돌아옴
		if (strlen($_POST['password']) < 5)
			echo "<script>alert('Your passwords is too short'); history.back();</script>";
		# 만약 입력한 비밀번호 값과 비밀번호 재입력값이 다르다면 경고 알림창이 뜨고 다시 재입력하도록 registration.php로 돌아옴
		else if ($_POST['password'] != $_POST['passconfirm'])
			echo "<script>alert('Your passwords do not match'); history.back();</script>";
		else {
	
			try {

				# dbcon.php에서 연결한 db인 $con에 쿼리문 진행
				# SINFO 테이블에서 사용자가 입력한 sinfo_nick과 같은 닉네임이 있는지 확인 진행
				$st_mt = $con->prepare("SELECT sinfo_nick FROM SINFO WHERE sinfo_nick = '$sinfo_nick'");
				$st_mt->bindparam(':sinfo_nick', $sinfo_nick);
				$st_mt->execute();
				$row = $st_mt->fetch();
				$is_nick_exists = $row['sinfo_nick'];

				# 같은 닉네임이 SINFO 테이블에 존재한다면 이미 존재하는 닉네임이라는 경고 알림창이 뜬다.
				if ($is_nick_exists)
					echo "<script>alert('$sinfo_nick Already exists. Try another nickname');</script>";
				# 기존에 없는 닉네임이라면 본격적인 회원가입 진행
				else {
					# dbcon.php에서 연결한 db인 $con에 쿼리문 진행
					# SINFO 테이블에 이름, 학번, 전공, 비밀번호, 이메일, 닉네임을 INSERT 한다.
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

					# db에 쿼리가 잘 진행된다면 설정되어있는 user_name, user_ssn, user_major에 대한 SESSION을 해제한다.
					# 회원가입에 성공했다는 알림창이 뜨고 로그인을 할 수 있도록 index.php로 이동
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