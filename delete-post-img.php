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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $previous_image = $post->image_file;

    if ($post->setImageFile($conn, null)) {

        if ($previous_image) {

            unlink("uploads/$previous_image");
        }

        header ("Location: edit-post-img.php?id={$post->id}");
    }
}

?>

<?php require 'includes/header.php'; ?>

<h3 class="edit-img-h2">Delete Post Image</h3>

<?php if ($post->image_file) : ?>
    <img src="uploads/<?= $post->image_file; ?>">
<?php endif; ?>

<form method="post">

    <p>Are you sure?</p>

    <button class="btn btn-danger">Delete</button>

    <a class="btn btn-info" href="edit-post-img.php?id=<?=$post->id; ?>" role="button">Cancel</a>

</form>

<?php require 'includes/footer.php'; ?>

