<?php

require 'includes/init.php';

Auth::requireLogin();

$conn = require 'includes/db.php';

$paginator = new Paginator($_GET['page'] ?? 1, 4, Post::getTotal($conn));

$posts = Post::getPage($conn, $paginator->limit, $paginator->offset);

?>

<?php require 'includes/header.php'; ?>


<?php if (empty($posts)): ?>
    <p>No posts found.</p>
<?php else: ?>

    <a class="btn btn-primary btn-new" href="new-post.php" role="button">New Post</a>

    <ul class="list-group">
        <?php foreach ($posts as $post): ?>
            <li class="list-group-item">
                <article>
                    <p class="date"><?=htmlspecialchars($post['published_at']); ?></p>
                    <h5><a href="post.php?id=<?= $post['id']; ?>"><?=htmlspecialchars($post['post_title']); ?></a></h5>
                    <p><?=htmlspecialchars($post['post_body']); ?></p>
                </article>
            </li>
        <?php endforeach; ?>
    </ul>
    
<?php require './includes/pagination.php'; ?>

<?php endif; ?>

<?php require 'includes/footer.php'; ?>
