<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<?php include('./inc/header.php') ?>
<?php include('./inc/navbar.php') ?>
 
<?php

  session_start();

  $name = $email = $pass = '';
  $nameErr = $emailErr = $passErr = '';

  if (isset($_POST['submit'])) {
    if(empty($_POST['name'])) {
      $nameErr = 'Name cannot be empty';
    } else {
      $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    if(empty($_POST['email'])) {
      $emailErr = 'Email cannot be empty';
    } else {
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    if(empty($_POST['password'])) {
      $passErr = 'Password cannot be empty';
    } else {
      $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
  }
  
  $_SESSION['name'] = $name;
  $_SESSION['password'] = $pass;

?>

<?php
try {
    $pdo = new PDO(
      'mysql:host=localhost;dbname=my_db','root', 'root'
    );

    session_start();

    if($name && $email && $pass) {
        if (isset($_POST['submit'])) {
          $sql = "INSERT INTO users (name, email, pass) VALUES ('$name', '$email', '$pass')";
          
          $q = $pdo->query($sql);
          $q->setFetchMode(PDO::FETCH_ASSOC);

          header('Location: /login.php');
        }

    }

}  catch(PDOException $e) {
  die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>

<main>
  <div class="container d-flex flex-column align-items-center">
    <h2>Create new acccount</h2>
    <form action="" class="w-50" method="post">
      <label for="name" class="form-label">Name: </label>
      <input class="form-control <?php echo !$nameErr ?: 'is-invalid'; ?>" type="text" name="name">
      <div class="invalid-title">
        <p class="text-danger"><?= $nameErr; ?></p>
      </div>
      <label for="email" class="form-label">E-mail: </label>
      <input class="form-control <?php echo !$emailErr ?: 'is-invalid'; ?>" type="email" name="email">
      <div class="invalid-title">
        <p class="text-danger"><?= $emailErr; ?></p>
      </div>
      <label for="name" class="form-label">Password: </label>
      <input class="form-control <?php echo !$passErr ?: 'is-invalid'; ?>" type="password" name="password">
      <div class="invalid-title">
        <p class="text-danger"><?= $passErr; ?></p>
      </div>
      <input type="submit" name="submit" value="Submit" class="btn btn-primary w-100">
    </form>
    
</main>