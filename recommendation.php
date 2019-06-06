<?php
	include("dbcon.php");
	try {
			$stmt = $con->prepare('SELECT LEC_NAME, LEC_SEME, EV_RECOM, EV_CONTENT, LEC_PROF, LEC_TYPE, LEC_CREDITS, EV_NICK
			 						FROM  Evaluation, Lectures 
			 						WHERE EV_LECNUM = LEC_NUM
			 						AND   EV_SEME = LEC_SEME
			 						AND   EV_RECOM > 7
			 						ORDER BY EV_RECOM DESC');
 			$stmt->execute();
	    } catch(PDOException $e) {
			die("Database error. " . $e->getMessage()); 
		}
?>

<!DOCTYPE html>
<html>
<head>
	<div class="page-header">
		<h1>강의평가 했Sook - 강의 추천</h1>
	</div>
	<div class="recommendation table">
		<?php
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$lecname = $row['LEC_NAME'];
		        $seme = $row['LEC_SEME'];
		        $star = $row['EV_RECOM'];
		        $content = $row['EV_CONTENT'];
		        $prof = $row['LEC_PROF'];
		        $type = $row['LEC_TYPE'];
		        $credits = $row['LEC_CREDITS'];
		        $nickname = $row['EV_NICK'];
		?>
			<table>
				<tr>
					<th>강의명</th>
					<td> <?php echo "$lecname"; ?> </td>
					<th>교수</th>
					<td><?php echo "$prof"; ?></td>
				</tr>
				<tr>
					<th>닉네임</th>
					<td><?php echo "$nickname"; ?></td>
					<th>평점</th>
					<td><?php echo "$star"; ?></td>
				</tr>
				<tr>
					<th>내용</th>
					<td><?php echo "$content"; ?> </td>
					<th>학점</th>
					<td><?php echo "$credits"; ?> </td>
				</tr>
				<tr>
					<th>학기</th>
					<td><?php echo "$seme"; ?></td>
					<td></td>
					<td></td>
				</tr>
			</table>
				<p>-----------------------------</p>
		<?php
			}
		?>
	</div>
</head>
<body>


</body>
</html>