<?php 

require 'includes/init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$conn = require 'includes/db.php';

	if (User::authenticate($conn, $_POST['username'], $_POST['password'])) {

		Auth::login();

		header("Location: index.php");

	} else {

		$error = "Login Incorrect";
	}
}

?>

<?php require 'includes/header.php'; ?>

<?php if (!empty($error)) : ?>
	<p class="errors"><?=$error; ?></p>
<?php endif; ?>

<main class="form-signin w-100 m-auto">

  <form method = "post">

    <h1 class="h3 mb-3 fw-normal">Please Login</h1>

    <div class="form-floating">
      <input name="username" type="text" class="form-control" id="username" placeholder="Username....">
      <label for="username">Username</label>
    </div>

    <div class="form-floating">
      <input name="password" type="password" class="form-control" id="password" placeholder="Password...">
      <label for="password">Password</label>
    </div>

    <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
    
  </form>
</main>










<!-- <form method="post">
	<div>		
		<label>Username: <input type="text" name="username" id="username"></label>
	</div>

	<div>		
		<label>Password: <input type="password" name="password" id="password"></label>
	</div>

	<div>
		<button>Log In</button>
	</div>
	
</form> -->

<?php require 'includes/footer.php'; ?>


