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

	try {

		if (empty($_FILES)) {

			throw new Exception('Invalid upload');
		}

		switch ($_FILES['file']['error']) {

			case UPLOAD_ERR_OK:
			break;

			case UPLOAD_ERR_NO_FILE:
			throw new Exception('No file uploaded');
			break;

			case UPLOAD_ERR_INI_SIZE:
			throw new Exception('File is too large (from the server settings');
			break;

			default:
			throw new Exception('An error occurred');
		}

		// Restrict the file size
		if ($_FILES['file']['size'] > 1000000) {

			throw new Exception('File is too large');
		}

		// Restrict the file type
		$mime_types = ['image/gif', 'image/png', 'image/jpeg'];

		$finfo = finfo_open(FILEINFO_MIME_TYPE);

		$mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);

		if (! in_array($mime_type, $mime_types)) {

			throw new Exception('Invalid file type');
		}

		// Move the uploaded file
		$pathinfo = pathinfo($_FILES["file"]["name"]);

		$base = $pathinfo['filename'];

		// Replace any characters that aren't letters, numbers, underscores or hyphens with an underscore
		$base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base);

		$base = mb_substr($base, 0, 200);



		$filename = $base . "." . $pathinfo['extension'];

		$destination = "uploads/" . $_FILES['file']['name'];

		// Add a numeric suffix to the filename to avoid overwriting existing files
		$i = 1;

		while (file_exists($destination)) {

			$filename = $base . "-$i." . $pathinfo['extension'];
			$destination = "uploads/$filename";

			$i++;
		}

		if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {

			$previous_image = $post->image_file;

			if ($post->setImageFile($conn, $filename)) {

				if ($previous_image) {

					unlink("uploads/$previous_image");
				}

				header ("Location: edit-post-img.php?id={$post->id}");
			}

		} else {

			throw new Exception('Unable to move uploaded file');
		}

	} catch (Exception $e) {

		$error = $e->getMessage();
	}	
}

?>

<?php require 'includes/header.php'; ?>

<h3 class="edit-img-h2">Edit Post Image</h3>

<?php if ($post->image_file) : ?>
	<img src="uploads/<?= $post->image_file; ?>">
	<a class="btn btn-danger" href="delete-post-img.php?id=<?=$post->id; ?>" role="button">Delete</a>
<?php endif; ?>

<?php if (isset($error)) : ?>
	<p><?=$error; ?></p>

<?php endif; ?>

<form method="post" enctype="multipart/form-data">
	<div class="mb-3">
		<label for="file" class="form-label">Choose New File</label>
		<input class="form-control" type="file" id="file" name="file">
	</div>

	<div class="d-grid gap-2">
		<button class="btn btn-primary" type="submit">Upload</button>
	</div>
</form><br><br>

<a href="index.php"><--Back</a>

	<?php require 'includes/footer.php'; ?>

