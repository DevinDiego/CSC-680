<?php 

require 'includes/init.php';

Auth::requireLogin();

$post = new Post();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $conn = require 'includes/db.php';

    $post->post_title = $_POST['post_title'];
    $post->post_body = $_POST['post_body'];
    $post->published_at = $_POST['published_at'];       

    if ($post->create($conn)) {

        header("Location: post.php?id={$post->id}");
        
    }   
}

?>

<?php require 'includes/header.php'; ?>

<h2>New Post</h2>

<?php require 'includes/post-form.php'; ?>

<?php require 'includes/footer.php'; ?>
