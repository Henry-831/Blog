<?php
	include_once('core/connection.php');
	include_once('functions/post.php');
	$post  = new Main;
	$check = new Main;
	$posts = $post->get_all_posts();
	$check_login = $check->logged_in();
?>
<html>
	<head>
		<title>Blog</title>
		<link rel="stylesheet" href="css/style.css">		
	</head>


	<body>
		<div class="wp">
		
		<div class="menu">
			<ul>
				<?php if($check_login == false){
			echo	'<li><a href="index.php">Home</a></li>
					 <li><a href="admin/adminpanel.php">Log in</a></li>';
			}else{
			 echo	'<li><a href="index.php">Home</a></li>
					<li><a href="add_new_post.php">Create New Post</a></li>
					<li><a href="admin/view_all_posts.php">View All Posts</a></li>
					<li><a href="admin/Logout.php">Logout</a></li>';
			}?>
		 
			</ul>
		</div>
		<div class="content">
		<?php foreach($posts as $post){?>
			
					<h1><a href="post.php?id=<?php echo $post['id']?>"><?php echo $post['title']?></a></h1>
				</div>
				<div class="post-img">
					<a href="post.php?id=<?php echo $post['id']?>"><img src="<?php echo $post['post_image']?>"></img></a>
				</div>
				<div class="post-body-s">
					<p><?php echo $post['description']?></p>
					<p><?php if (strlen($post['content']) <=20) {
                              echo $post['content'];
                               } else {
                                  echo substr($post['content'], 0, 50) . '...Click Post To Read More';
                                       }?></p>


				</div>
				
					<p><?php echo $post['published_date']?></p>
					<p><?php echo $post['author']?></p>

				
				<?php }?>
			
		<div class="footer">
		</div>
	</body>
</html>