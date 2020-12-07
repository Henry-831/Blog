<?php 
	include ('core/connection.php');
	include ('functions/main.php');
	if(isset($_SESSION['loggedin'])===false){
		header('Location: index.php');
	}else{
	//check if user Publish a post
 	if($_POST){
		$ptitle = $_POST['post_title'];
		$pdescription = $_POST['post_des'];
		$pcontent = $_POST['post_content'];
		$pauthor = $_POST['post_author'];
		$pdate = date("Y-m-d H:i:s");
		
		if(empty($ptitle) && empty($pdescription) && empty($pcontent) && empty($pauthor)){
			$errors = '<div class="error2"><p> All fields are required to post. Please try again</p></div>';
		}
		  else if (empty($ptitle)) {
		$errors = '<div class="error2"><p> A Title is required. Please try again</p></div>';
	    } else if (empty($pdescription)) {
		$errors = '<div class="error2"><p> A Description is required. Please try again</p></div>';
		} else if (empty($pauthor)) {
			$errors = '<div class="error2"><p> An Author is required. Please try again</p></div>';
	    } else if (empty($pcontent)) {
		$errors = '<div class="error2"><p> Content is required. Please try again</p></div>';
		}
		else {
			//check if post image isset
			if (isset($_FILES['post_image'])===true) {		 
				if (empty($_FILES['post_image']['name']) ===true) {
					$errors = '<div class="error2">An Image is required. Please try again</div>';
				 
				 }else {   
				 	//check image format                                                                                                    
					 $allowed = array('jpg','jpeg','gif','png'); 
					 $file_name = $_FILES['post_image']['name']; 
					 $file_extn = strtolower(end(explode('.', $file_name)));
					 $file_temp = $_FILES['post_image']['tmp_name'];
					 
					 if (in_array($file_extn, $allowed)===true) {
					 		//rename image name 
							$file_path = 'images/' . substr(md5(time()), 0, 10).'.'.$file_extn;
							//move image to our image folder
							move_uploaded_file($file_temp, $file_path);						 	
							$query = $pdo->prepare("INSERT INTO `blog`.`posts` (`id`, `title`, `description`, `content`, `published_date`, `post_image` , `author`) VALUES (NULL, ?, ?, ?, ?, ?, ?)");
							$query->bindValue(1, $ptitle);	
							$query->bindValue(2, $pdescription);	
							$query->bindValue(3, $pcontent);	
							$query->bindValue(4, $pdate);	
							$query->bindValue(5, $file_path);
							$query->bindValue(6, $pauthor);
 							$query->execute();	
							header('Location: admin/view_all_posts.php');	

					 }
				 	}
				}
						

		}



		
	}
	
?>


<html>
	<head>
		<title>Add new post - Admin</title>
		<link rel="stylesheet" href="css/style.css">
		<script type="text/javascript" src="js/jquery.js"></script>
	   <script src="ckeditor/ckeditor.js"></script>		
	</head>


	<body>
		<div class="wp">
		
		<div class="menu">
			<ul>
				<?php if($check_login == false){
			echo	'<li><a href="index.php">Home</a></li>';
					 
			}else{
			 echo	'<li><a href="index.php">Home</a></li>';
					
			}?>
		 
			</ul>
		</div>
		<form action="" method="post" enctype="multipart/form-data">
			<ul>
				<li><h2>Post title</h2><input name="post_title" class="inputer" type="text"></input></li>
				<li><input class="submit" value="Publish" type="submit"></input></li>
			</ul>
		</div>
		<div class="content">
				<!--show error if isset-->
				<?php if(isset($errors)){
						echo $errors;
					}?>
				<div class="editer">
					<textarea id="editor"rows="3" name="post_content"></textarea>
				</div>
			</div>
			<div class="right-side">
				<div class="right-menu">
					<ul>
						<li><h3>Description</h3><textarea rows="3" name="post_des"></textarea></li>
						<li><h3>Author</h3><textarea rows="1" name="post_author"></textarea></li>
						<li><h3>Upload Post Image</h3><input type='file' name="post_image" id="imgInput" /></li>
						<li><img id="preview" src="#"/></li>
						
					</ul>
					</form>
				</div>
				<script>
          		  CKEDITOR.replace( 'editor' );
          		  function readURL(input) {

				    if (input.files && input.files[0]) {
				        var reader = new FileReader();

				        reader.onload = function (e) {
				            $('#preview').attr('src', e.target.result);
				        }

				        reader.readAsDataURL(input.files[0]);
				        $('#preview').show();
				    }
				}

					$("#imgInput").change(function(){
					    readURL(this);
					});
        		</script>
			</div>
		</div></div>
		<div class="footer">
			
		</div>
	
	</body>
</html>
<?php } ?>