<?php
	include_once('../core/connection.php');
	if(isset($_SESSION['loggedin'])===false){
		header('Location: ../index.php');
	}else{


?>
<html>
	<head>
		<title>Delete Post</title>
		<link rel="stylesheet" href="../css/style.css">		
	</head>


	<body>
		<div id="header">
			<div id="logo">
				<H1><a href="index.php" style="color:#fff; text-decoration:none;">MERA-CMS</a></h1>
			</div>

			<div id="menu">
				<ul>
					<li><a href="index.php">HOME</a></li>
				</ul>
			</div>
		</div>

		<div id="content">
			<?php 
				if(isset($_GET['delete_id'])){
					$del_id = $_GET['delete_id'];
					$query = $pdo->prepare("DELETE FROM `posts` WHERE `posts`.`id` = ?");
					$query->bindValue(1,$del_id);
					$query->execute();
					header('Location: view_all_posts.php');
					exit();
				}
			?>
			</div>
		</div>
	</body>
</html>
<?php } ?>