<?php 

require 'includes/init.php';

$conn = require 'includes/db.php';

if (isset($_GET['id'])) {

	$post = Post::getPostId($conn, $_GET['id']);

	if (!$post) {

		die("Post not found!");
	} 

} else {

	die("id not supplied for deleting!");
}

// Only be able to delete using "post"
if ($_SERVER['REQUEST_METHOD'] == "POST") {

	if ($post->delete($conn)) {         

		header("Location: index.php");
		exit;
	}
}

?>

<?php require 'includes/header.php'; ?>

<h2>Delete Post</h2>

<form method="post">

	<p>Are you sure you want to delete this post!</p>

	<button type="submit" class="btn btn-outline-primary">DELETE</button>

	<button type="submit" class="btn btn-outline-primary"><a href="post.php?id=<?=$post->id; ?>">CANCEL</a></button>	

</form>

<?php require 'includes/footer.php'; ?>
