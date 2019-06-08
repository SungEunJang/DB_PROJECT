<?php

    include("dbcon.php");
    $usernick = $_SESSION['usernick'];
    $QA_num = $_POST['list_num'];
    $_SESSION['list_num'] = $QA_num;

    if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['list_num']) ){
         $REPLY_content = $_POST['comment'];

         $REPLY_nick = $usernick;
         $REPLY_date = date('Y-m-d h:i:s');
    }
    try{
        $stmt = $con->prepare('INSERT INTO REPLY (REPLY_nick,REPLY_content,REPLY_date,REPLY_NN) 
                            VALUES( :REPLY_nick, :REPLY_content, :REPLY_date, :REPLY_NN)');
        $stmt->bindParam(':REPLY_nick', $REPLY_nick);
        $stmt->bindParam(':REPLY_content', $REPLY_content);
        $stmt->bindParam(':REPLY_date', $REPLY_date);
        $stmt->bindParam(':REPLY_NN', $QA_num);

        if ($stmt->execute()) {
            header("Location: qlook.php");
        }
        else {
            echo '<script>alert("Err");</script>';
        }

    } catch(PDOException $e) {
        die("Database error. " . $e->getMessage()); 
    }       
?>