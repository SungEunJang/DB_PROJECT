<?php

include('dbcon.php'); 
    error_reporting(E_ALL); 
    ini_set('display_errors',1); 


function is_login(){

    global $con;

    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ){

        $stmt = $con->prepare("select username from users where username=:username");
        $stmt->bindParam(':username', $_SESSION['user_id']);
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

<div class="container">
	<div class="page-header">
    	<h1 class="h2">&nbsp; 강의평가 했SOOK</h1><hr>
    </div>
<div class="row">

    <table class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
        <thead>  
        <tr>  
            <th>학기정보</th>  
            <th>학점 </th>
            <th>내용</th>
            <th>보기</th>  
             
        </tr>  
        </thead>  
  
        <?php  

	    $stmt = $con->prepare('SELECT * FROM Evaluation ORDER BY id DESC');
	    $stmt->execute();
        $EV_SEME = $_POST["seme"];
        $EV_STAR = $_POST["star"];

            if ($stmt->rowCount() > 0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	        {
		    extract($row);
       if ($username != 'admin'){
        ?>  
            <tr>  
            <td><?php echo $EV_SEME;  ?></td> 
            <td><?php echo $EV_STAR; ?></td>
            <td>
            <?php 
            if($activate)
            { 
                echo "추천";
            } else{
                echo "비추천";
            }
            ?>
            </td>
            <td><a class="btn btn-primary" href="editform.php?edit_id=<?php echo $EV_SEME ?>"><span class="glyphicon glyphicon-pencil"></span> 추천 </a></td> 
            
            </tr> 
        
        <?php
            }
                }
             }
        ?>  
		
		
			 
        </table>  
</div>

</body>
</html>