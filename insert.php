
<?php
    //데이터 베이스 연결하기
    include("dbcon.php");
        $ev_seme = $_POST['seme'];
        $ev_star = $_POST['star'];
        $ev_lecnum = $_POST['lecnum'];
        $ev_nick = $_POST['nick'];
        $ev_content = $_POST['content'];

        


    #$REMOTE_ADDR = $_SERVER[REMOTE_ADDR];


        $stmt = $con->prepare(
                        'INSERT INTO Evaluation (EV_SEME,EV_STAR,EV_LECNUM,EV_NICK, EV_CONTENT) 
                        VALUES( :EV_SEME,:EV_STAR,:EV_LECNUM,:EV_NICK,:EV_CONTENT)');

        
                $stmt->bindParam(':EV_SEME', $ev_seme);
                $stmt->bindParam(':EV_STAR', $ev_star);
                $stmt->bindParam(':EV_LECNUM', $ev_lecnum);
                $stmt->bindParam(':EV_NICK', $ev_nick);
                $stmt->bindParam(':EV_CONTENT', $ev_content);
        



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
