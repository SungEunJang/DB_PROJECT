<?php
	include('dbcon.php');
	$usernick = $_SESSION['usernick'];
    if (isset($_SESSION['list_num']))
        unset($_SESSION['list_num']);
?>

<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        #topMenu { 
            height: 30px;
            width: 850px;
        }
        #topMenu ul li { 
            list-style: none; 
            color: white;
            background-color: #2d2d2d; 
            float: left;
            line-height: 30px;
            vertical-align: middle; 
            text-align: center;
        }
         #topMenu .menuLink {
            text-decoration:none;
            color: white;
            display: block;
            width: 150px;
            font-size: 12px; 
            font-weight: bold;
            font-family: "Trebuchet MS", Dotum, Arial;
        } 
        #topMenu .menuLink:hover { 
            color: red;
            background-color: #4d4d4d;
        }
    </style>
    <title></title>
    <div class="menubar">
        <nav id="topMenu">
            <ul>
                <li><a class="menuLink" href="main.php">강의평가</a></li>
                <li><a class="menuLink" href="recommendation.php">강의추천</a></li>
                <li><a class="menuLink" href="qtest.php">Q&A</a></li>
                <li><a class="menuLink" href="logout.php">로그아웃</a></li>
            </ul>
        </nav>
    </div>
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
