<?php  
	include ('../core/connection.php');
	include ('../functions/main.php');
	$check = new Main;
	$check_login = $check->logged_in();
	
?>
<!DOCTYPE html>
<html>

<head>

	<link rel="stylesheet" href="../css/style.css"/>
	
</head>

<body>
	
		
		<?php if($check_login === false){?>
		<div class="content">
			
				
			<div class="intro">
				
			
			</div>
			<?php 
				include('login.php');
			}else{
				header('Location: view_all_posts.php');
			}
			?>
		<div class="footer">
		
		</div>
	</div>
</body>
</html>