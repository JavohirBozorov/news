<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<?php include('./inc/header.php') ?>
<?php include('./inc/navbar.php') ?>

<?php

    session_start();

    try {
        $pdo = new PDO(
            'mysql:host=localhost;dbname=my_db', 'root', 'root'
        );
    
        // Table of main info
        $id = $_GET['id'];
        $sql = "SELECT title, body, author, image, date, shortBody, id
            FROM news
            WHERE id = $id";
    
        $q = $pdo->query($sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
    
        // Table of comments section
        $sql2 = "SELECT id, comment, date, owner, post_id
                FROM comments
                WHERE post_id = $id";
        $q2 = $pdo->query($sql2);
        $q2->setFetchMode(PDO::FETCH_ASSOC);
        
        $comment = $commentErr = '';
        if(!empty($_SESSION['username'])) {
            $owner = $_SESSION['username'];
        }
        if(isset($_POST['submit'])) {
            if(empty($_POST['comment'])) {
                $commentErr = 'Comment cannot be empty';
            } elseif(empty($_SESSION['username'])){
                $commentErr = 'You must register first';
            } else {
                $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }

            if(isset($_POST['submit'])) {
            }

            if(empty($commentErr)){
                $sql3 = "INSERT INTO comments (comment, owner, post_id) VALUES ('$comment', '$owner', '$id')";
                $q3 = $pdo->query($sql3);
                $q3->setFetchMode(PDO::FETCH_ASSOC);
                $comment = '';
                header('Location: /app/post.php?id=' . $id);
            }

        }
    } catch(PDOException $e) {
        die("Could not connect to the database $dbname :" . $e->getMessage());
    }
    
    ?>
<main style="box-sizing: border-box;overflow-x: hidden;">
    <div class="row d-flex justify-content-between px-5">
        <div class="col-lg-9">
            <section>
                <?php $row = $q->fetch(); ?>
                <div class="date d-flex">
                    <i class="bi bi-calendar3 mt-1"></i>
                    <p class="text-start fw-lighter mx-2">
                        <?php
                            $phpdate = strtotime($row['date']);
                            $mysqldate = date('H:i / d.m.Y', $phpdate);
                            echo($mysqldate);
                        ?>
                    </p>
                </div>
                <h3 class="text-center mb-2">   
                    <?php echo $row['title'] . '<br>'; ?>
                </h3>
                <div class="img-blok my-4">
                    <?php echo '<img class="w-100 img-fluid" src="' . './images/' . $row['image'] . '" alt="img">' . '<br>'; ?>
                </div>
                <p class="mb-3 fs-5">
                    <?php echo $row['shortBody'] . '<br>'; ?>
                </p>
                <p class="fs-5">
                    <?php echo $row['body'] . '<br>'; ?>
                </p>
                <p class="text-end blockquote-footer fs-5">
                    <span class="blockquote px-4">
                        <?php echo $row['author']; ?>
                    </span>
                </p>
            </section>

            <section class="input-comment">
              <div class="row">
                <div class="col">
                  <form action="" method="POST">
                    <div class="input-group my-3">
                      <textarea
                        <?= $commentErr ? 'required' : null; ?>
                        type="text"
                        class="form-control shadow-none"
                        placeholder="Write a comment..."
                        aria-describedby="basic-addon2"
                        name="comment"
                      ></textarea>
                      <input
                        class="input-group-text btn btn-light border"
                        id="basic-addon2"
                        type="submit"
                        name="submit"
                        value="Submit">
                    </div>
                    <div class="invalid-title">
                        <p class="text-danger"><?= $commentErr; ?></p>
                    </div>
                  </form>

                </div>
              </div>
              <div class="row">
                <?php while ($row2 = $q2->fetch()) {  ?>
                    <div class="col-12 my-2">
                        <p class="comments bg-light rounded p-2">
                            <?php
                                echo $row2['owner'] . '<br>';
                                echo $row2['comment'] . '<br>';
                                echo $row2['date'] . '<br>';
                            ?>
                        </p>
                    </div>
                <?php } ?>
              </div>
            </section>
        </div>
        <?php include('./inc/latest-news.php') ?>
    </div>
</main>

<?php include('./inc/footer.php'); ?>