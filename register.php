<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<?php include('./inc/header.php') ?>
<?php include('./inc/navbar.php') ?>
 
<?php

require_once(__DIR__ . '/classes/EmptyElement.php');
require_once(__DIR__ . '/classes/RegisterPDO.php');

session_start();

$filter = new EmptyElement();

if (isset($_POST['submit'])) {
  $arr = $filter->filterInput($_POST);
  $name = $arr['fields']['name'] ?? '';
  $email = $arr['fields']['email'] ?? '';
  $pass = $arr['fields']['password'] ?? '';
  $nameErr = $arr['errors']['name'] ?? '';
  $emailErr = $arr['errors']['email'] ?? '';
  $passErr = $arr['errors']['password'] ?? '';
}

try {

  $register = new registerPDO();
  
  if (isset($_POST['submit'])) {
    $register->registerFunction($name, $email, $pass);
  }

}  catch(PDOException $e) {
  die("Could not connect to the database $dbname :" . $e->getMessage());
}

if(isset($_SESSION['name'])) {
  $_SESSION['name'] = $name;
}

?>

<main>
  <div class="container d-flex flex-column align-items-center">
    <h2>Create new acccount</h2>
    <form action="" class="w-100" method="post">
      <label for="name" class="form-label">Name: </label>
      <input class="form-control <?php echo !$nameErr ?: 'is-invalid'; ?>" type="text" name="name">
      <div class="invalid-title">
        <p class="text-danger"><?= isset($nameErr) ? $nameErr : ''; ?></p>
      </div>
      <label for="email" class="form-label">E-mail: </label>
      <input class="form-control <?php echo !$emailErr ?: 'is-invalid'; ?>" type="email" name="email">
      <div class="invalid-title">
        <p class="text-danger"><?= isset($emailErr) ? $emailErr : ''; ?></p>
      </div>
      <label for="name" class="form-label">Password: </label>
      <input class="form-control <?php echo !$passErr ?: 'is-invalid'; ?>" type="password" name="password">
      <div class="invalid-title">
        <p class="text-danger"><?= isset($passErr) ? $passErr : ''; ?></p>
      </div>
      <input type="submit" name="submit" value="Submit" class="btn btn-primary w-100">
    </form>
  </div> 
</main>