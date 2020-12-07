<?php
	include_once('../core/connection.php');
	include_once('../functions/Main.php');
	$post  = new Main;
	$check = new Main;
	$posts = $post->get_all_posts();
	$check_login = $check->logged_in();
	if($check_login === false){
		header('Location: ../index.php');
	}else{

?>
<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="../css/style.css"/>
</head>

<body>
<div class="wp">
		
		<div class="menu">
			<ul>
				<li><a href="../index.php">Home</a></li>
				<li><a href="../add_new_post.php">Create New Post</a></li>
 				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
        <div id="content">
			<div class="posts-holder">
			<?php foreach($posts as $post){?>
				<table>
					<tbody>
						<tr class="tr-st">
							
								<div class="check">
									
								</div>
							</td>
							
								<div class="post-link">
									<a href="../post.php?id=<?php echo $post['id'];?>"><?php echo $post['title'];?></a>
								</div>
							</td>
							
								<div class="post-hidden">
									<a href="edit.php?post_id=<?php echo $post['id'];?>">Edit</a>|<a href="../post.php?id=<?php echo $post['id'];?>">View</a>|<a href="#" class="post_delete" name="<?php echo $post['id']; ?>" onClick="deletepost(<?php echo $post['id']; ?>)">Delete</a>|
								</div>
							</td><?php }?>
							<script type="text/javascript">
								function deletepost(x){
									var conf = confirm("Are you sure you want to delete this post?");
									if(conf == true){
									window.location = "delete.php?delete_id="+x;
									}
								}
							</script>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
<div class="footer">
			
		</div>
</body>
</html>
<?php }?>

