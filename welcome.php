<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<?php include('./inc/header.php') ?>
<?php include('./inc/navbar.php') ?>

  <section class="text-center">
    <?php if($_POST["name"] == 'admin' && $_POST["password"] == 'pass') {
        header('Location: /app/admin.php');
      } elseif($_POST["name"] !== 'admin' && $_POST["password"] !== 'pass') { ?>
        <h4>
          Welcome <?php echo $_POST["name"]; ?><br>
        </h4>
      <?php  } ?>
  </section>
