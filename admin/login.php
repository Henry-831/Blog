<?php


	if(isset($_POST['username'],$_POST['password'])){
		@$username = $_POST['username'];
		@$password = md5($_POST['password']);
		
		if(empty($username) or empty($password)){
			$error  = "<div class='error'>Enter a Username and Password</div>";
		} else{
			$query = $pdo->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
			$query->bindValue(1,$username);
			$query->bindValue(2,$password);
 			$query->execute();

			$num = $query->rowCount();

			if($num == 1){
				$_SESSION['loggedin'] = true;
				$_SESSION['username'] = $username;
				header('Location: view_all_posts.php');
				exit();
			}else{
				$error  =  '<div class="error">incorrect details!</div>';
			}
		}

	}
 ?>

<div class="right-side">
				<div class="login-box">
			
			<form action="" method="post">
			<div class="login-body">
				<input type="text"     name="username" placeholder="Enter your Username"></input>
				<input type="password" name="password" placeholder="Enter your Password"></input>
			</div>
			<div class="login-footer">
				<input type="submit" value="Login"></input>
			</div>
			</form>
			<div class="login-error">
					<?php 
					if(isset($error)){
						echo $error;
					}
					?>
			</div>
		</div>
			</div>
			</div>
		</div>

	