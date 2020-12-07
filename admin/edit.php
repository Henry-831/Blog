<?php
include_once('../core/connection.php');
include_once('../functions/main.php'); 
$post = new Main;
if(isset($_SESSION['loggedin'])===false){
	header('Location: ../index.php');
}else{
	if(isset($_GET['post_id'])){
		$pid = $_GET['post_id'];
		$post = $post->fetch_data($pid);
		//if user update post
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
			//check if image is isset
			if (isset($_FILES['post_image'])===true) {		 
				if (empty($_FILES['post_image']['name']) ===true) {
					$errors = '<div class="error2">Please Choose a Post Image</div>';
				 
				 }else {    
				 	//check image format                                                                                                   
					 $allowed = array('jpg','jpeg','gif','png'); 
					 $file_name = $_FILES['post_image']['name']; 
					 $file_extn = strtolower(end(explode('.', $file_name)));
					 $file_temp = $_FILES['post_image']['tmp_name'];
					 
					 if (in_array($file_extn, $allowed)===true) {
					 		//move image to our path
							$file_path = 'images/' . substr(md5(time()), 0, 10).'.'.$file_extn;
							$file_path_new = '../images/' . substr(md5(time()), 0, 10).'.'.$file_extn;
							move_uploaded_file($file_temp, $file_path_new);	
							//update post with new data 					 	
							$query = $pdo->prepare('UPDATE `posts` SET `title` = ?, `description` = ?, `post_image` = ?, `published_date` = ?, `content` = ?, `author` = ? WHERE `id` = ?; ');
                            $query->bindValue(1, $ptitle); 
                            $query->bindValue(2, $pdescription); 
                            $query->bindValue(3, $file_path); 
                            $query->bindValue(4, $pdate); 
							$query->bindValue(5, $pcontent);
							$query->bindValue(6, $pauthor);
	                        $query->bindValue(7, $pid);
                            $query->execute(); 
                            header('Location: view_all_posts.php'); 


					 }
				 	}
				}
						

		}



		
	}
		?>
	<html>
		<head>
			<title>Edit - Post</title>
			<link rel="stylesheet" href="../css/style.css">
				   <script src="../ckeditor/ckeditor.js"></script>		
		
		</head>


		<body>
			<div class="wp">
		<div class="menu">
		<form action="" method="post" enctype="multipart/form-data">
			<ul>
				<li><h2>Post title</h2><input name="post_title" class="inputer" type="text" value="<?php echo $post['title'];?>"></input></li>
				<li><input class="submit" value="Update" type="submit"></input></li>
			</ul>
		</div>
		<div class="content">
			<div class="left-side">
			<!---- show erros if isset -->
				<?php if(isset($errors)){
						echo $errors;
					}?>
				<div class="editer">
					<textarea id="editor"rows="3" name="post_content"><?php echo $post['content'];?></textarea>
				</div>
			</div>
			<div class="right-side">
				<div class="right-menu">
					<ul>
						<li><h3>Description</h3><textarea rows="3" name="post_des"><?php echo $post['description'];?></textarea></li>
						<li><h3>Author</h3><textarea rows="3" name="post_author"><?php echo $post['author'];?></textarea></li>
						<li><h3>Upload Post Image</h3><input type='file' name="post_image" id="imgInput" /></li>
						<li><img id="preview" style="display:block;" src="../<?php echo $post['post_image'];?>"/></li>
						
					</ul>
					</form>
				</div>
				<script>
				//replace texarea with editor
          		  CKEDITOR.replace( 'editor' );
          		  function readURL(input) {
          		  	//image preview function
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
		</div>
		<div class="footer">
			
		</div>
	</div>
		</body>
	</html>

		<?php
	}
	else{
		header('Location:index.php');
	}
}
?>
