
<?php
    //데이터 베이스 연결하기
    include("dbcon.php");
        $te_seme = $_POST['seme'];
        $te_lecnum = $_POST['lecnum'];
        $te_nick = $_POST['nick'];
        $te_content = $_POST['content'];
        
    
    #$REMOTE_ADDR = $_SERVER[REMOTE_ADDR];


        $stmt = $con->prepare(
                        'INSERT INTO Etest (TE_SEME,TE_LECNUM,TE_NICK, TE_CONTENT) 
                        VALUES( :TE_SEME,:TE_LECNUM,:TE_NICK,:TE_CONTENT)');



    $stmt->bindParam(':TE_SEME', $te_seme);
                $stmt->bindParam(':TE_LECNUM', $te_lecnum);
                $stmt->bindParam(':TE_NICK', $te_nick);
                $stmt->bindParam(':TE_CONTENT', $te_content);


    if ($stmt->execute()) {
                    
                    echo '<script>alert("Registration Success!");</script>';
                    echo "<script>location.href='main.php'</script>";
                }
                else {
                    echo '<script>alert("Err");</script>';
                }



    //데이터베이스와의 연결 종료
    //mysql_close($con);

    // 새 글 쓰기인 경우 리스트로..
    echo ("<meta http-equiv='Refresh' content='1; URL=main.php'>");
    

?> 
