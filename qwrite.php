<?php
    include("dbcon.php");
    $usernick = $_SESSION['usernick'];
?>

<html>
<head>
    <meta charset="UTF-8">
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
    </style>
    
    <title></title>

    <div class="menubar">
        <nav id="topMenu">
            <ul>
                <li><a class="menuLink" href="main.php">강의평가</a></li>
                <li><a class="menuLink" href="recommendation.php">강의추천</a></li>
                <li><a class="menuLink" href="qtest.php">Q&A</a></li>
                <li><a class="menuLink" href="logout.php">로그아웃</a></li>
            </ul>
        </nav>
    </div>

    <title>질문 하SOOK </title>
</head>


<body topmargin=0 leftmargin=0 text=#464646>
    <center>
    <BR>
    <form action="" method=post>
        <table width=580 border=0 cellpadding=2 cellspacing=1 bgcolor=#777777>
            <tr>
                <td height=20 align=center bgcolor=#999999>
                <font color=blue><B>QnA</B></font>
                </td>
            </tr>

            <tr>
                <td bgcolor=white>&nbsp;
                <table>
                    <tr>
                        <td width=60 align=left > 제  목 </td>
                        <td align=left >
                            <input id="title" type="text" name="title" size=20 maxlength=10>
                        </td>
                    </tr>
                    <tr>
                        <td width=60 align=left > 이 름   </td>
                        <td align=left > <p> <?php echo $usernick; ?> </p> </td>
                    </tr>
                    <tr>
                        <td width=60 align=left > 내 용  </td>
                        <td align=left >
                             <TEXTAREA id = "content" name="content" cols=65 rows=15></TEXTAREA>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=10 align=center>
                            <button type="submit" name = "register">저장하기</button>  
                            &nbsp;&nbsp;
                            <button type="reset" name = "reset">다시쓰기</button>  
                            &nbsp;&nbsp;
                            <button type="button" name ="back"
                            onclick="history.back(-1)">되돌아가기</button>
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
        </table>
    </form>
    </center>
</body>
</html>

<?php

    if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['register']) ) {
        $QA_title = $_POST['title'];
        $QA_content = $_POST['content'];
        $QA_date = date('Y-m-d h:i:s');
        $QA_nick = $usernick;

        $QA_num = $_POST['list_num'];
        
        $stmt_qa = $con->prepare('INSERT INTO QnA (QA_title,QA_nick,QA_content,QA_date, QA_num) 
                            VALUES( :QA_title,:QA_nick,:QA_content,:QA_date,:QA_num)');

        $stmt_qa->bindParam(':QA_title', $QA_title);
        $stmt_qa->bindParam(':QA_nick', $QA_nick);
        $stmt_qa->bindParam(':QA_content', $QA_content);
        $stmt_qa->bindParam(':QA_date', $QA_date);
        $stmt_qa->bindParam(':QA_num', $QA_num);

       if ($stmt_qa->execute()) {
            echo '<script>alert("Registration Success!");</script>';
            echo "<script>location.href='qtest.php'</script>";
        } else {
            echo '<script>alert("Err");</script>';
        }
        echo ("<meta http-equiv='Refresh' content='1; URL=qtest.php'>");
    }
    
?>









