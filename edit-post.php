<?php 

require 'includes/init.php';

Auth::requireLogin();

$conn = require 'includes/db.php';

if (isset($_GET['id'])) {

	$post = Post::getPostId($conn, $_GET['id']);

	if (!$post) {

		die("Post not found!");
	} 

} else {

	die("id not supplied for editing!");
}

var_dump($post->getCategories($conn));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$post->post_title = $_POST['post_title'];
	$post->post_body = $_POST['post_body'];
	$post->published_at = $_POST['published_at'];     	

	if ($post->update($conn)) {

		header("Location: post.php?id={$post->id}");
		exit;
	}	
}

?>

<?php require 'includes/header.php'; ?>

<h2>Edit Post</h2>

<?php require 'includes/post-form.php'; ?>

<?php require 'includes/footer.php'; ?>

