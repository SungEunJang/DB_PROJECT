<!-- 
    본 파일인 authentication.php는 회원가입을 진행하기 위해 숙명여대 학생인지 인증하는 단계의 페이지입니다.
    본인의 이름, 학번, 전공을 입력하면 숙명여대 학생들의 정보를 담고 있는 릴레이션인 Students_reg를 검색합니다.
    Students_reg에 존재하는 학생이라면 본 학교 학생이므로 '강의평가 했sook'의 회원가입 페이지인 registration.php로 넘어갑니다.
-->

<?php
    #로그인이 되어있는지 확인하는 함수 is_login()을 사용하기 위해여 logincheck.php를 본 페이지에 포함시킨다.
    include("logincheck.php");

    if (is_login()) {
        header("Location: main.php");       // 로그인이 되어으므로 index.php 페이지에 접속을 못하고 main.php로 바로 넘어간다.
    } else {
        ;                                   // 로그인이 안 되어있으므로 아무것도 하지 않고 authentication.php에 머무른다.
    }
?>


<html>
<head>
    <meta charset="UTF-8">

    <h1>Register</h1>
</head>

<body>
    <h2>Authentication :</h2>
    <form action = "" method="post">Your...
        <p><input type="form-control" name="user_name" placeholder="Name"></p>
        <p><input type="form-control" name="user_ssn" placeholder="SSN"></p>

        <select name="major" size="1" name="major">

        <?php
            $conn = new mysqli('localhost', 'root', 'password', 'final_project') 
            or die ('Cannot connect to db');
            # 학교 학생들의 데이터가 저장 되어있는 테이블인 students_reg의 전공 value를 쿼리로 부른다.
            $result = $conn->query("SELECT stu_major FROM STUDENTS_REG GROUP BY stu_major ORDER BY stu_major");
            
            while ($row = $result->fetch_assoc()) {                         # 쿼리를 진행한 모든 행에 대하여 while 루프를 돈다.
                $major = $row['stu_major'];                                 # 현재 행의 stu_major value를 받아오고
                echo "<option value=\"$major\">" . $major . "</option>";    # option값의 value와 
            }
        ?>
        </select>

        <br><br>
        <div>
            <button type="submit" name="auth" >Next...</button>
        </div>
    </form>
</body>
</head>
</html>

<?php
    
    include("dbcon.php");
    
    if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['auth']) ) {

        $username=$_POST['user_name'];  
        $userssn=$_POST['user_ssn'];  
        $usermajor=$_POST['major'];

        # 이름 입력창과 학번 입력창이 공백이라면 경고창 출력
        if ($username == "" || $userssn == "")
            echo '<script>alert("Err : Name or SSN is blank");</script>';
        else {
            try { # 학교 학생인지 검색하기 위해서 사용자가 입력한 ssn 으로 DB에서 쿼리 진행
                $stmt = $con->prepare("SELECT stu_name, stu_ssn, stu_major FROM students_reg WHERE stu_ssn='$userssn'");
                $stmt->bindParam(':stu_ssn', $userssn);
                $stmt->execute();
            } catch(PDOException $e) {
                die("Database error. " . $e->getMessage()); 
            }
            
            # students_reg 테이블의 stu_ssn = (사용자가 입력한 ssn)인 열에 대해서 stu_name의 value와 stu_major의 value값을 받아옴
            $row = $stmt->fetch();  
            $checkname  = $row['stu_name'];
            $checkmajor = $row['stu_major'];
            
            # 만약 table의 stu_name value값과 사용자가 입력한 name value값이 같고 stu_major의 value값과 사용자가 입력한 major value값이 같다면,
            # 즉 테이블에 존재하는 학생이라면, 회원가입을 진행할 수 있도록 한다.
            if ($checkname == $username && $checkmajor == $usermajor) {
                try {               # 학교 학생임을 인증했지만 이미 회원가입을 한 상태인지 확인하기 위해 SINFO 테이블에 검색 쿼리
                    $stmt = $con->prepare("SELECT * FROM SINFO WHERE sinfo_ssn='$userssn'");
                    $stmt->bindParam(':sinfo_ssn', $userssn);
                    $stmt->execute();
                    $st_row = $stmt->fetch();       
                    if ($st_row)    # 사용자가 입력한 학번이 있는 열이 SINFO에 존재한다면 이미 회원가입 한 상태임을 경고창으로 알려주고 index.php 페이지에 머무른다.
                        echo '<script>alert("You already registered."); history.back(); </script>';
                    else {          # SINFO 테이블에 존재하지 않는 학번이라면 SESSION으로 사용자의 이름, 학번, 전공 value를 갖고 회원가입 홈페이지인 registration.php로 이동한다.
                        $_SESSION['user_name'] = $username; 
                        $_SESSION['user_ssn']  = $userssn;  
                        $_SESSION['user_major'] = $usermajor;
                        echo "<script>location.href='registration.php'</script>";
                    }
                } catch(PDOException $e) {
                    die("Database error. " . $e->getMessage()); 
                }
            }
            # STUDENTS_REG 테이블에 사용자가 입력한 이름, 학번, 전공이 모두 일치하는 학번이 없다면 학교 학생이 아니므로 deniedaccess.php 페이지로 이동한다.
            else
                echo "<script>location.href='deniedaccess.php'</script>";
        }
    }
?>