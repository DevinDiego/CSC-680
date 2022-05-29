<?php

require 'includes/init.php';

Auth::requireLogin();

$conn = require 'includes/db.php';

if (isset($_GET['id'])) {

    $post = Post::getPostId($conn, $_GET['id']);

} else {

    $post = null;
}

$paginator = new Paginator($_GET['page'] ?? 1, 6, Post::getTotal($conn));

$posts = Post::getPage($conn, $paginator->limit, $paginator->offset);

?>

<?php require 'includes/header.php'; ?>

<h2 class="admin-h2">Administration</h2>    


<a class="btn btn-primary admin-btn" href="new-post.php" role="button">New Post</a>

<?php if (empty($posts)): ?>
    <p>No posts found.</p>
<?php else: ?>

    <table>
        <thead>
            <th>Title</th>            
        </thead>
        <tbody>        

            <?php foreach ($posts as $post): ?>
                <tr>
                    <td>
                        <a href="post.php?id=<?= $post['id']; ?>"><?=htmlspecialchars($post['post_title']); ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>    
    
    <?php require './includes/pagination.php'; ?>   

<?php endif; ?>

<?php require 'includes/footer.php'; ?>
