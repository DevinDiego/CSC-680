<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Coding Cave</title>

  <!-- Icon in title -->
  <link rel = "icon" href = 
  "img/icon.png" 
  type = "image/x-icon">

  <!-- Bootstrap  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Press+Start+2P&display=swap" rel="stylesheet">

  <!-- custom stylesheet -->
  <link rel="stylesheet" type="text/css" href="css/styles.css">

</head>
<body>    

  <!-- BEGIN bootstrap container "div" which closes in footer.php -->
  <div class="container">
    <header>
      <h1 class="h1">Coding Cave</h1>
    </header>        

    <!-- Navigation Links -->

    <nav class="navbar navbar-expand-lg bg-light">
      <div class="container-fluid">        
        <a class="navbar-brand" href="index.php">
          <img class="icon" src="img/icon.png" alt="Techno Babble" width="50" height="50">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.php">About</a>
            </li>

            <?php if (Auth::isLoggedIn()) : ?>

              <li class="nav-item"><a class="nav-link" href="logout.php">Log out</a></li>

            <?php else : ?>

              <li class="nav-item"><a class="nav-link" href="login.php">Log in</a></li>

            <?php endif; ?>

          </ul>
        </div>
      </div>
    </nav>
    <main>