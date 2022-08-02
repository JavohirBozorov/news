<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<?php include('./inc/header.php') ?>
<?php include('./inc/navbar.php') ?>
 
<?php

  session_start();

  $msg = '';
  $name = $pass = '';
  $nameErr = $passErr = '';

  if (isset($_POST['submit'])) {
    if(empty($_POST['name'])) {
      $nameErr = 'Name cannot be empty';
    } else {
      $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    if(empty($_POST['password'])) {
      $passErr = 'Password cannot be empty';
    } else {
      $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    try {
      $pdo = new PDO(
        'mysql:host=localhost;dbname=my_db','root', 'root'
      );
      
      $sql = "SELECT id, name, pass, email
        FROM users
        WHERE name = \"$name\" AND pass = \"$pass\"";
    
      $q2 = $pdo->query($sql);
      $_SESSION['username'] = $q2->fetchAll()[0]['name'];
      if($name == 'admin') {
        header('Location: ./admin.php');
      } elseif(!empty($_SESSION['username'])) {
        $msg = $_SESSION['username'] . ' are successfully login' ;
      } else {
        $msg = 'Try again. You cannot login!';
      }
    } catch(PDOException $e) {
      die("Could not connect to the database $dbname :" . $e->getMessage());
    }
  }

?>

<main>
  <div class="container row d-flex flex-column align-items-center">
    <h2 class="text-center">Login</h2>
    <p><?= $msg; ?>
    <form action="" class="col-lg-8 col-md-10 col" method="post">
        <label for="name" class="form-label">Name: </label>
        <input class="form-control <?= !$nameErr ?: 'is-invalid'; ?>" type="text" name="name">
        <div class="invalid-title">
          <p class="text-danger"><?= $nameErr; ?></p>
        </div>
      <label for="name" class="form-label">Password: </label>
      <input class="form-control <?= !$passErr ?: 'is-invalid'; ?>" type="password" name="password">
      <div class="invalid-title">
        <p class="text-danger"><?= $passErr; ?></p>
      </div>
      <input type="submit" name="submit" value="Submit" class="btn btn-dark w-100">
      <p class="text-center mt-5">Don't have an account? <a href="./register.php" class="text-decoration-none">Sign Up for free</a></p>
    </form>
  </div>
</main>

