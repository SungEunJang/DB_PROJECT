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
            $result = $conn->query("select stu_major from students_reg group by stu_major order by stu_major");
            while ($row = $result->fetch_assoc()) {
                $major = $row['stu_major'];
                echo "<option value=\"$major\">" . $major . "</option>";
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

        if ($username == "" || $userssn == "")
            echo '<script>alert("Err : Name or SSN is blank");</script>';
        else {     
            echo "<script>alert('Name : $username SSN : $userssn Major : $usermajor');</script>";

            try { 

                $stmt = $con->prepare("SELECT stu_name, stu_ssn, stu_major FROM students_reg WHERE stu_ssn='$userssn'");

                $stmt->bindParam(':stu_ssn', $userssn);
                $stmt->execute();

               
            } catch(PDOException $e) {
                die("Database error. " . $e->getMessage()); 
            }

            $row = $stmt->fetch();  
            $checkname  = $row['stu_name'];
            $checkmajor = $row['stu_major'];

            if ($checkname == $username && $checkmajor == $usermajor) {
                try {
                    stmt = $con->prepare("SELECT * FROM SINFO WHERE sinfo_ssn='$userssn'");
                    stmt->bindParam(':sinfo_ssn', $userssn);
                    if ($stmt->execute())
                        echo '<script>alert("You already registered.");</script>';
                    else {
                        $_SESSION['user_name'] = $username; 
                        $_SESSION['user_ssn']  = $userssn;  
                        $_SESSION['user_major'] = $usermajor;
                        echo "<script>location.href='registration.php'</script>";
                    }
                } catch(PDOException $e) {
                    die("Database error. " . $e->getMessage()); 
                }

               
            }
            else
                echo "<script>location.href='deniedaccess.php'</script>";
        }
    }
?>

aX