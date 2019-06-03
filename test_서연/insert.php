<?
    //데이터 베이스 연결하기
    include("dbcon.php");

    $seme = $_post[seme];
    $star = $_POST[star];
    $lecnum = $_POST[lecnum];
    $nick = $_POST[nick];
    $content = $_POST[content];
    $recom = $_POST[recom];
    $id = $_GET[id];
    
    #$REMOTE_ADDR = $_SERVER[REMOTE_ADDR];

    $query = "INSERT INTO Evaluation 
   (EV_SEME,EV_STAR,EV_LECNUM,EV_NICK,EV_CONTENT,EV_RECOM,id,EV_VIEW)
    VALUES ('$seme', '$star', '$lecnum', '$nick', '$content', 
    '$recom','$id',0)";
    $result=mysql_query($query, $conn) or die(mysql_error());

    //데이터베이스와의 연결 종료
    mysql_close($conn);

    // 새 글 쓰기인 경우 리스트로..
    echo ("<meta http-equiv='Refresh' content='1; URL=list.php'>");
    
?>
<center>
<font size=2>정상적으로 저장되었습니다.</font>






