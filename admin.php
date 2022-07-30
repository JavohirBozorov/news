<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<?php include('./inc/header.php') ?>
<?php include('./inc/navbar.php') ?>

<?php

  try{

    $pdo = new PDO(
      'mysql:host=localhost;dbname=my_db','root', 'root'
    );
  
    $title = $shortBody = $body = $author = '';
    $titleErr = $shortBodyErr = $bodyErr = $authorErr = '';

    if(isset($_POST['submit'])) {
      if(empty($_POST['title'])) {
        $titleErr = 'Title is required';
      } else {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      }
      if(empty($_POST['shortBody'])) {
        $shortBodyErr = 'Short description is required';
      } else {
        $shortBody = filter_input(INPUT_POST, 'shortBody', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      }
      if(empty($_POST['body'])) {
        $bodyErr = 'Main Text is required';
      } else {
        $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      }
      if(empty($_POST['author'])) {
        $authorErr = 'Author is required';
      } else {
        $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      }

      $msg = "";
      if(empty($titleErr) && empty($shortBodyErr) && empty($bodyErr) && empty($authorErr)) {
        if (isset($_POST['submit'])) {
          $image = $_FILES["choosefile"]["name"];
          $tempname = $_FILES["choosefile"]["tmp_name"];
          $folder = __DIR__ . "/images/" . $image;
          $sql = "INSERT INTO news (title, shortbody, body, image, author) VALUES ('$title', '$shortBody', '$body', '$image', '$author')";
          if (move_uploaded_file($tempname, $folder)) {
            $msg = "Image uploaded successfully";
          } else {
            $msg = "Failed to upload image";
          }
          
          $q = $pdo->query($sql);
          $q->setFetchMode(PDO::FETCH_ASSOC);

          header('Location: /admin.php');
        }

      }

    }
  } catch(PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
  }
 ?>

<?php // if($_POST['username'] == 'admin') { ?>
  <section class="text-center">
    <h3>Welcome Admin</h3>
  </section>
  <main>
    <div class="container d-flex flex-column align-items-center">
      <!-- Image uploader -->
      <form action="admin.php" method="POST" enctype="multipart/form-data" class="w-75">
        <div class="mb-2">
          <label for="image" class="form-label">Image</label>
          <input type="file" class="form-control <?php echo !$titleErr ?: 'is-invalid'; ?>" id="image" name="choosefile" placeholder="Enter image of new article">
          <div class="invalid-image">
            <p class="text-danger"><?= '' ?></p>
          </div>
        </div>
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control <?php echo !$titleErr ?: 'is-invalid'; ?>" id="title" name="title" placeholder="Enter title of new article">
          <div class="invalid-title">
            <p class="text-danger"><?= $titleErr; ?></p>
          </div>
        </div>
        <div class="mb-3">
          <label for="shortBody" class="form-label">Short description</label>
          <textarea type="text" class="form-control <?php echo $shortBodyErr ? 'is-invalid' : null; ?>" rows="2" id="shortBody" name="shortBody" placeholder="Enter short text of article"></textarea>
          <div class="invalid-shortBody">
            <p class="text-danger"><?= $shortBodyErr; ?></p>
          </div>
        </div>
        <div class="mb-3">
          <label for="body" class="form-label">Main Text</label>
          <textarea type="text" class="form-control <?php echo $bodyErr ? 'is-invalid' : null; ?>" rows="3" id="body" name="body" placeholder="Enter body of article"></textarea>
          <div class="invalid-body">
            <p class="text-danger"><?= $bodyErr; ?></p>
          </div>
        </div>
        <div class="mb-3">
          <label for="author" class="form-label">Author</label>
          <input type="text" class="form-control <?php echo $authorErr ? 'is-invalid' : null; ?>" id="author" name="author" placeholder="Enter author of new article">
          <div class="invalid-author">
            <p class="text-danger"><?= $authorErr;  ?></p>
          </div>
        </div>
        <div class="mb-3">
          <input type="submit" name="submit" value="Submit" class="btn btn-dark w-100 mb-5">
        </div>
      </form>
  </main>

<?php include('./inc/footer.php') ?>