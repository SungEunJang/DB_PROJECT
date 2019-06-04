<?php

include('dbcon.php'); 
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
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
                <th>과목 </th>
                <th>내용</th>  
                 
            </tr>  
            </thead>  
      
            <?php  

                $stmt = $con->prepare('SELECT LEC_NAME,EV_SEME,EV_STAR,EV_CONTENT FROM Evaluation,Lectures WHERE EV_LECNUM IN (LEC_NUM) ORDER BY id DESC');
                #$EV_SEME = $_POST["seme"];
                #$EV_STAR = $_POST["star"];
                #$EV_CONTENT = $_POST["content"];
                #$LEC_NAME = $_POST["name"];
                $stmt->bindParam(':LEC_NAME', $LEC_NAME);
                $stmt->bindParam(':EV_SEME', $EV_SEME);
                $stmt->bindParam(':EV_STAR', $EV_START);
                $stmt->bindParam(':EV_CONTENT', $EV_CONTENT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        if ($username != 'admin'){
            ?>  
                        <tr>  
                            <td><?php echo $EV_SEME;  ?></td> 
                            <td><?php echo $EV_STAR; ?></td>
                            <td><?php echo $LEC_NAME; ?></td>
                            <td><?php echo $EV_CONTENT; ?></td>

                    
                            <td><a class="btn btn-primary" href="editform.php?edit_id=<?php echo $EV_SEME ?>"><span class="glyphicon glyphicon-pencil"></span> 추천 </a></td> 
                    
                        </tr> 
            
            <?php
                        }
                    }
                }
            ?> 
            </table>
            <a href=write.php>글쓰기</a>  
    </div>

</body>
</html>