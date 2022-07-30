<?php session_start(); ?>
<nav class="navbar navbar-expand-sm navbar-light bg-light mb-4">
  <div class="container">
    <a class="navbar-brand" href="./index.php">News</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          
          <li class="nav-item">
            <a class="nav-link" href="./index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php if(empty($_SESSION["username"])) { echo './login.php'; } else { echo './logout.php'; } ?>">
              <?php if(empty($_SESSION["username"])) { echo 'Login'; } else { echo 'Logout'; } ?>
              <?php // header('Location: ./inc/logout.php'); ?>
            </a>
          </li>
          <li class="nav-item" style="display: <?= (!empty($_SESSION["username"]) && $_SESSION["username"] == 'admin') ? 'block' : 'none' ?>">
            <a class="nav-link" href="<?= ($_SESSION["username"]) == 'admin' ? './admin.php' : '' ?>">
              Admin
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>