
<html>
<head>
    <meta charset="UTF-8">
<title>강의 평가 했SOOK </title>
<style>
<!--
td { font-size : 9pt; }
A:link { font : 9pt; color : black; text-decoration : none; 
font-family : 굴림; font-size : 9pt; }
A:visited { text-decoration : none; color : black; font-size : 9pt; }
A:hover { text-decoration : underline; color : black; 
font-size : 9pt; }
-->
</style>

</head>


<body topmargin=0 leftmargin=0 text=#464646>
<center>
<BR>
<!-- 입력된 값을 다음 페이지로 넘기기 위해 FORM을 만든다. -->
<form action="insert.php" method=post>
<table width=580 border=0 cellpadding=2 cellspacing=1 bgcolor=#777777>
    <tr>
        <td height=20 align=center bgcolor=#999999>
        <font color=blue><B>강 의 평</B></font>
        </td>
    </tr>
    <!-- 입력 부분 -->
    <tr>
        <td bgcolor=white>&nbsp;
        <table>
            <tr>
                <td width=60 align=left >닉 네 임</td>
                <td align=left >
                    
                    <input id = "nick" type="text" name="nick" size=20 maxlength=10>
                </td>
            </tr>
            <tr>
                <td width=60 align=left >학 기 정 보  </td>
                <td align=left >
                    <input id ="seme" type="text" name="seme" size=20 maxlength=25>
                </td>
            </tr>
            <tr>
                <td width=60 align=left >학 점   </td>
                <td align=left >
                    <input id= "star" type="text" name=
                    "lecname" size=20 maxlength=25> 
                </td>
            </tr>
           
            <tr>
                <td width=60 align=left >강 의 번 호 </td>
                <td align=left >
                    <INPUT id = "lecnum" type="text" name=
                    "lecnum" size=60 maxlength=35>
                </td>
            </tr>
            <tr>
                <td width=60 align=left >내용</td>
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
                    onclick="history.back(-1)">되돌아가기</button><!--버튼이 클릭되었을때 발생하는 이벤트로 자바스크립트를 실행함. 이렇게 하면 바로 이전페이지 감-->
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


    <!---->






