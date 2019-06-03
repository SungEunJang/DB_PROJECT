<html>
<head>
<title>강의 평가 했숙</title>
<style>
<!--
td { font-size : 9pt; }
A:link { font : 9pt; color : black; text-decoration : none; 
font-family: 굴림; font-size : 9pt; }
A:visited { text-decoration : none; color : black; 
font-size : 9pt; }
A:hover { text-decoration : underline; color : black; 
font-size : 9pt;}
-->
</style>
</head>

<body topmargin=0 leftmargin=0 text=#464646>
<center>
<BR>
<!-- 입력된 값을 다음 페이지로 넘기기 위해 FORM을 만든다. -->
<form action=update.php?id=<?=$_GET[id]?> method=post>
<table width=580 border=0 cellpadding=2 cellspacing=1 bgcolor=#777777>
    <tr>
        <td height=20 align=center bgcolor=#999999>
            <font color=white><B>글 수 정 하 기</B></font>
        </td>
    </tr>
<?
    //데이터 베이스 연결하기
    #include "db_info.php";
    include("dbcon.php");
    $id = $_GET[id];
    $no = $_GET[no];

    // 먼저 쓴 글의 정보를 가져온다.
    $result=mysql_query("SELECT * FROM Evaluation  WHERE id=$id", $conn);
    $row=mysql_fetch_array($result);
?>
<!-- 입력 부분 -->
    <tr>
        <td bgcolor=white>&nbsp;
        <table>
            <tr>
                <td width=60 align=left >학기정보 </td>
                <td align=left >
                    <INPUT type=text name=seme size=40 
                    value="<?=$row[seme]?>">
                </td>
            </tr>
            <tr>
                <td width=60 align=left >별점 </td>
                <td align=left >
                    <INPUT type=text name=star size=40 
                    value="<?=$row[star]?>">
                </td>
            </tr>
            <tr>
                <td width=60 align=left >내 용</td>
                <td align=left >
                    <TEXTAREA name=content cols=85 rows=35><?=$row[content]?></TEXTAREA>
                </td>
            </tr>
            <tr>
                <td width=60 align=left >닉 네 임 </td>
                <td align=left >
                    <INPUT type=text name=nick size=40 
                    value="<?=$row[nick]?>">
                </td>
            </tr>
            
            <tr>
                <td width=60 align=left >추 천 </td>
                <td align=left >
                    <INPUT type=text name=recom size=40 
                    value="<?=$row[recom]?>">
                </td>
            </tr>
            <tr>
                <td colspan=10 align=center>
                    <INPUT type=submit value="글 저장하기">
                    &nbsp;&nbsp;
                    <INPUT type=reset value="다시 쓰기">
                    &nbsp;&nbsp;
                    <INPUT type=button value="되돌아가기" 
                    onclick="history.back(-1)">
                </td>
            </tr>
            </TABLE>
        </td>
    </tr>
<!-- 입력 부분 끝 -->
</table>
</form>
</center>
</body>
</html>


