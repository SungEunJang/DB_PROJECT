<?php

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    function is_login(){

        global $con;

        if (isset($_SESSION['usernick']) && !empty($_SESSION['usernick']) ){

            $stmt = $con->prepare("SELECT sinfo_nick FROM sinfo WHERE sinfo_nick = :usernick");
            $stmt->bindParam(':usernick', $_SESSION['usernick']);
            $stmt->execute();
            $count = $stmt->rowcount();

            if ($count == 1){
           
                return true; //로그인 상태
            }else{
                //사용자 테이블에 없는 사람
                return false;
            }
        }else{

            return false; //로그인 안된 상태
        }
    }
?>