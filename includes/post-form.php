<!-- repeated form used for creating and editing a post -->

<?php if (!empty($post->errors)) : ?>
    <ul class="errors">
        <?php foreach($post->errors as $error) : ?>
            <li><?=$error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form class="form" action="" method="post">

    <div class="input-group input-group-lg">
        <span class="input-group-text" id="inputGroup-sizing-lg">Title:</span>
        <input name="post_title" id="post_title" type="text" class="form-control" value="<?=htmlspecialchars($post->post_title); ?>">
    </div>

    <div class="form-floating">
        <textarea name="post_body" id="post_body" class="form-control" placeholder="Post Body..." style="height: 100px"><?=htmlspecialchars($post->post_body); ?></textarea>
        <label for="floatingTextarea">Post body content...</label>        
    </div>

    <div class="date-time">
        <label>Post date and time: <input type="datetime-local" name="published_at" id="published_at" value="<?=htmlspecialchars($post->published_at); ?>"></label>        
    </div>

    <div class="d-grid gap-2">
      <button class="btn btn-primary" type="submit">Submit</button>

  </div><br>

  <a href="index.php"><--Back</a>


</form>










