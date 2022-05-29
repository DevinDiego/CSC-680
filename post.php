<?php

require 'includes/init.php';

Auth::requireLogin();

$conn = require 'includes/db.php';

if (isset($_GET['id'])) {

	$post = Post::getWithCategories($conn, $_GET['id']);

} else {

	$post = null;
}

?>

<?php require 'includes/header.php'; ?>

<?php if ($post): ?>

	<article>
		<h5><?= htmlspecialchars($post[0]['post_title']); ?></h5>

		<?php if ($post[0]['category_name']) : ?>
			<p class="category">Category:
				<?php foreach ($post as $p) : ?>
					<?= htmlspecialchars($p['category_name']); ?>
				<?php endforeach; ?>
			</p>
		<?php endif; ?>

		<?php if ($post[0]['image_file']) : ?>
			<img src="uploads/<?= $post[0]['image_file']; ?>">
		<?php endif; ?>

		<p><?=htmlspecialchars($post[0]['post_body']); ?></p>
	</article>
	

	<a class="btn btn-primary" href="edit-post.php?id= <?= $post[0]['id']; ?>" role="button">Edit Post</a>
	<a class="btn btn-primary" href="edit-post-img.php?id=<?=$post[0]['id']; ?>" role="button">Edit Image</a>
	<a class="btn btn-danger" href="delete-post.php?id=<?=$post[0]['id']; ?>" role="button">Delete</a><br><br>

	<div>
		<a href="index.php?page="><--Back</a>		
		</div>



	<?php else: ?>

		<p>Post not found.</p>	

	<?php endif; ?>

	<?php require 'includes/footer.php'; ?>
