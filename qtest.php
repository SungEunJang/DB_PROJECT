<?php
include('dbcon.php'); 
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <form action="qlook.php" method=post>
    <div class="container">
    <div class="page-header">
        <h1 class="h2">&nbsp; 궁금한게 있SOOK</h1><hr>
    </div>
    <div class="row">

        <table class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
            <thead>  
            <tr>  
                <th>작성일 </th>
                <th>Question</th>  
                <th>글쓴이 </th>
  
            </tr>  
            </thead>  
      
            <?php  

                $stmt = $con->prepare('SELECT * FROM QnA');

                $stmt->bindParam(':QA_date', $QA_date);
                $stmt->bindParam(':QA_title', $QA_title);
                $stmt->bindParam(':QA_nick', $QA_nick);
                $stmt->bindParam(':QA_num', $QA_num);

                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);

                        if ($username != 'admin'){
            ?>  
                        <tr>  
                            <td><?php echo $QA_date; ?></td>
                            <td>
                            	<?php 
                            	echo "<button name='list_num' style='border: none; background-color :white;' type='submit' value='$QA_num'>" . $QA_title ."</button>";
                            	?>
                            </td> 
                            <td><?php echo $QA_nick; ?></td>
                        </tr> 
            
            <?php
                        }
                    }
                }
            ?> 
            </table>
            <a href=qwrite.php>질문 하기</a>  
            </form>
    </div>

</body>
</html>