<?php

    include('dbcon.php');

    $QA_num = $_POST['list_num'];

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
    <title></title>
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
    

</body>
</html>