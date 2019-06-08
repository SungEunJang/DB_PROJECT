<?php

    include('dbcon.php');
    $usernick = $_SESSION['usernick'];
    
    if (isset($_SESSION['list_num'])) {
        $QA_num = $_SESSION['list_num'];
    }
    else {
        $QA_num = $_POST['list_num'];
    }

    try {
        $stmt = $con->prepare("SELECT QA_title, QA_nick, QA_content, QA_date
                            FROM  QnA
                            WHERE QA_num = '$QA_num'");
        $stmt->execute();
    } catch(PDOException $e) {
        die("Database error. " . $e->getMessage()); 
    }

    $row = $stmt->fetch();
    $QA_title = $row['QA_title'];
    $QA_nick = $row['QA_nick'];
    $QA_date = $row['QA_date'];
    $QA_content = $row['QA_content'];

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
</head>
<body>
    <div class="container">
    <div class="page-header">
        <h1 class="h2">&nbsp; 궁금한거 보SOOK</h1><hr>
    </div>

    <table>
        <tr>
            <td>제목 <?php echo $QA_title;?></td>
        </tr>
        <tr>
            <td>작성자 <?php echo $QA_nick;?> </td>
        </tr>
        <tr>
            <td>작성날짜 <?php echo $QA_date;?></td>
        </tr>
        <tr>
            <td>내용</td>
        </tr>
        <tr>
            <td><?php echo $QA_content;?></td>
        </tr>
    </table>
    <br><br>
    <table>
        <?php
            try {
                $stmt_reply = $con->prepare("SELECT REPLY_nick, REPLY_content, REPLY_date
                                            FROM  reply
                                            WHERE REPLY_NN = '$QA_num'");
                $stmt_reply->execute();
            } catch (PDOException $e) {
                die("Database error. " . $e->getMessage()); 
            }
            while ($row = $stmt_reply->fetch(PDO::FETCH_ASSOC)) {
                $reply_nick = $row['REPLY_nick'];
                $reply_content = $row['REPLY_content'];
                $reply_date = $row['REPLY_date'];
        ?>
            <table>
                <tr>
                    <td>작성자 <?php echo $reply_nick; ?></td>
                    <td>작성날짜 <?php echo $reply_date; ?></td>
                </tr>
                    <td colspan="2"><?php echo $reply_content; ?></td>
                <tr>

                </tr>
            </table>
        <?php
            }
        ?>
    </table>

    <br><br>
    <form action="qread.php" method="post">
        <table>
        <tr>
            <td width =30 align = left>댓글</td>
        </tr>
           <tr>
                <td width=0 align=left colspan="2">닉네임 <?php echo $usernick; ?></td>
            </tr>
            <td align = left> 
                <TEXTAREA id = "comment" name = "comment" cols = 40, rows = 5></TEXTAREA>
            </td>
            <td align =right>
                <?php echo "<button type='submit' name='list_num' value='$QA_num'>등록하기</button>"; ?>
        </td>
            </tr>
                
    </table>
</form>
</body>
</html>