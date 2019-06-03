<?
    //데이터 베이스 연결하기
    #include "db_info.php";
    include("dbcon.php");
    $seme = $_POST[seme];
    $star = $_POST[star];
    $lecnum = $_POST[lecnum];
    $nick = $_POST[nick];
    $content = $_POST[content];
    $recom = $_POST[recom];
    $id = $_GET[id];
    $SINFO_pass = $_POST[SINFO_pass];
    // 글의 비밀번호를 가져온다.
    $query = "SELECT EV_NICK FROM Evaluation WHERE id=$id";
    $result=mysql_query($query, $conn);
    $row=mysql_fetch_array($result);

    //입력된 값과 비교한다.
    if ($pass==$row[SINFO_pass]) { //비밀번호가 일치하는 경우
        $query = "UPDATE Evaluation SET EV_SEME='$seme', EV_STAR='$star',
        EV_LECNUM='$lecnum', content='$content',EV_RECOM='$recom' WHERE id=$id";//업데이트 쿼리문
        $result=mysql_query($query, $conn);
    }
    else { // 비밀번호가 일치하지 않는 경우
        echo ("
        <script>
        alert('비밀번호가 틀립니다.');
        history.go(-1);
        </script>
        ");
        exit;//반드시 exit를 써줘야됨. 안그러면 아래의 코드가 실행이됨.
    }

    //데이터베이스와의 연결 종료
    mysql_close($conn);

    //수정하기인 경우 수정된 글로..
    echo ("<meta http-equiv='Refresh' content='1; 
    URL=read.php?id=$id'>");
?>
<center>
<font size=2>정상적으로 수정되었습니다.</font>

