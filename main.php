<?php
    include('dbcon.php'); 
    include('logincheck.php');

     if (is_login()) {
        $usernick = $_SESSION['usernick'];
    } else {
        header("Location: index.php");
    }
    

    try {
        $stmt = $con->prepare("SELECT DISTINCT LEC_SEME FROM Lectures");      
        $stmt->execute();
    } catch(PDOException $e) {
        die("Database error. " . $e->getMessage()); 
    }
?>

<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
    #topMenu {   // 참고 : https://unikys.tistory.com/333
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

     <script type="text/javascript">

        function displaySeme(obj) {
            if (obj.options[obj.selectedIndex].id % 2 == 1) {
                document.getElementById("seme1").style.display = "block";
                document.getElementById("seme2").style.display = "none";
            }
            else if (obj.options[obj.selectedIndex].id % 2 == 0){
                document.getElementById("seme1").style.display = "none";
                document.getElementById("seme2").style.display = "block";
            }
            else {
                document.getElementById("seme1").style.display = "none";
                document.getElementById("seme2").style.display = "none";
            }
        }
    </script>
    <div class="menubar">
        <nav id="topMenu">
            <ul>
                <li><a class="menuLink" href="main.php">강의평가</a></li>
                <li><a class="menuLink" href="recommendation.php">강의추천</a></li>
                <li><a class="menuLink" href="qtest.php">Q&A</a></li>
                <li><a class="menuLink" href="logout.php">로그아웃</a></li>
                <li><a class="menuLink" href="leaveaccount.php">회원탈퇴</a></li>
            </ul>
        </nav>
    </div>
</head>

<body>
    <div class="page-header">
        <h1 class="h2">&nbsp; 강의평가 했SOOK</h1><hr>
    </div>

    <div id=left_banner>
        <form action="" method=post>
            <table width=400 border=0 cellpadding=2 cellspacing=1 bgcolor=#777777>
                <tr>
                    <font20 align=centnt color=blue><B>강 의 평</B></font>
                </tr>
                <tr>
                    <td bgcolor=white>&nbsp;
                        <table>
                            <tr>
                                <th width=0 align=left >닉네임</th>
                                <td align=left > <?php echo "<p>" . $usernick . "</p>"; ?></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td width=30 align=left >학기정보  </td>
                                <td align=left >
                                    <select name="seme" id="seme" size="1" onchange="displaySeme(this)">
                                        <option id="blank" value=""></option>
                                    <?php
                                        $count = 1;
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $lec_seme = $row['LEC_SEME'];
                                            echo "<option id=\"$count\" value=\"$lec_seme\">" . $lec_seme . "</option>";
                                            $count++;
                                        }
                                        $count = 1;
                                    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width=30 align=left >강의명</td>
                                <td align=left >
                                    <select name="seme1" id="seme1" size="1" style="display: none">
                                        <option value=""></option>
                                        <option value="영화를통한법의이해">영화를통한법의이해</option>
                                        <option value="통계학">통계학</option>
                                        <option value="여성의여행안전을위한안전기술">여성의여행안전을위한안전기술</option>
                                        <option value="웨이트트레이닝">웨이트트레이닝</option>
                                    </select>
                                    <select name="seme2" id="seme2" size="1" style="display: none">
                                        <option value=""></option>
                                        <option value="서버운영과보안">서버운영과보안</option>
                                        <option value="융합적사고와글쓰기">융합적사고와글쓰기</option>
                                    </select>
                                </td>
                            </tr>
               
                            <tr>
                                <td width=100 align=left >별점 </td>
                                <td align=left >
                                    1점 <input id="star" name="star" type="range" min="1" max="10" step="1"/> 10점
                                </td>
                            </tr>
                            <tr>
                                <td width=30 align=left >내용</td>
                                <td align=left >
                                    <TEXTAREA id = "content" name="content" cols=40 rows=15></TEXTAREA>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=10 align=center>
                                    <button type="submit" name = "register">저장하기</button>  
                                    &nbsp;&nbsp;
                                    

                                    <button type="reset" name = "reset">다시쓰기</button>  
                                    &nbsp;&nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
             </table>
        </form>

        <?php
            if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['register']) ) {
                $ev_nick = $usernick;
                $ev_recom = $_POST['star'];
                $lec_seme = $_POST['seme'];
                $ev_content = $_POST['content'];
                $ev_time = date('Y-m-d h:i:s');

                if ($_POST['seme1'] == "")
                    $lec_name = $_POST['seme2'];
                else
                    $lec_name = $_POST['seme1'];

                try {

                    $stmt_lecnum = $con->prepare("SELECT LEC_NUM 
                                                FROM Lectures 
                                                WHERE LEC_SEME = '$lec_seme' 
                                                AND LEC_NAME = '$lec_name'"
                                            );
                    $stmt_lecnum->bindParam(':LEC_NUM', $lecnum);
                    $stmt_lecnum->execute();
                    $row = $stmt_lecnum->fetch();
                    $lecnum = $row['LEC_NUM'];
                } catch(PDOException $e) {
                    die("Database error. " . $e->getMessage()); 
                }

                $ev_lecnum = $lecnum;
                $ev_seme = $lec_seme;

                try {
                    $stmt = $con->prepare(
                                    'INSERT INTO Evaluation (EV_SEME,EV_RECOM,EV_LECNUM,EV_NICK, EV_CONTENT, EV_TIME) 
                                    VALUES( :EV_SEME, :EV_RECOM, :EV_LECNUM, :EV_NICK, :EV_CONTENT, :EV_TIME)');
                    $stmt->bindParam(':EV_SEME', $ev_seme);
                    $stmt->bindParam(':EV_RECOM', $ev_recom);
                    $stmt->bindParam(':EV_LECNUM', $ev_lecnum);
                    $stmt->bindParam(':EV_NICK', $ev_nick);
                    $stmt->bindParam(':EV_CONTENT', $ev_content);
                    $stmt->bindParam(':EV_TIME', $ev_time);

                    if ($stmt->execute()) {
                        echo "<script>location.href='main.php'</script>";
                    }
                    else {
                        echo '<script>alert("Err");</script>';
                    }

                } catch(PDOException $e) {
                    die("Database error. " . $e->getMessage()); 
                }
                echo ("<meta http-equiv='Refresh' content='1; URL=main.php'>");
            }
        ?>
    </div>

    <div class="right_list" id="right_list">
            <?php  
                $stmt = $con->prepare('SELECT LEC_NAME, EV_SEME, LEC_CREDITS, EV_CONTENT, EV_RECOM, EV_NICK, LEC_PROF, LEC_TYPE
                                    FROM Evaluation,Lectures 
                                    WHERE EV_LECNUM IN (LEC_NUM) 
                                    ORDER BY EV_TIME DESC');

                $stmt->bindParam(':LEC_NAME', $LEC_NAME);
                $stmt->bindParam(':EV_SEME', $EV_SEME);
                $stmt->bindParam(':LEC_CREDITS', $LEC_CREDITS);
                $stmt->bindParam(':EV_CONTENT', $EV_CONTENT);
                $stmt->bindParam(':EV_STAR', $EV_STAR);
                $stmt->bindParam(':EV_NICK', $EV_NICK);
                $stmt->bindParam(':LEC_PROF', $LEC_PROF);
                $stmt->bindParam(':LEC_TYPE', $LEC_TYPE);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
            ?>  
                <table style="table-layout: fixed; width: 600px" id="eval_list">  
                    <tr>
                        <td>작성자 <?php echo $EV_NICK; ?></td>
                    </tr>
                    <tr>
                        <td>강의명 <?php echo $LEC_NAME; ?> </td>
                        <td>교수명 <?php echo $LEC_PROF; ?> </td>
                    </tr>
                    <tr>
                        <td>강의유형 <?php echo $LEC_TYPE; ?> </td>
                        <td><?php echo $LEC_CREDITS; ?>학점</td>
                    </tr>
                        <td>학기 <?php echo $EV_SEME;  ?></td>  
                        <td>평점 <?php echo $EV_RECOM; ?></td>                    
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo $EV_CONTENT; ?></td>
                    </tr>
                </table>
                <br>
            <?php
                        }
                    }
            ?> 
    </div>

</body>
</html>
