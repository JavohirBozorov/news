<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<?php


try{

    $pdo = new PDO(
        'mysql:host=localhost;dbname=my_db',
        'root', 'root'
    );
    
    $sql2 = "SELECT title, date, image, shortBody, id
        FROM news
        ORDER BY id DESC";
    
    $q2 = $pdo->query($sql2);
    $q2->setFetchMode(PDO::FETCH_ASSOC);
   
} catch(PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

?>

<div class="col-12 col-lg-3 ps-1">
    <div class="row">
        <div class="col mb-3">
            <i class="bi bi-record-circle-fill"></i>
            <h5 class="d-inline pb-5">Latest News</h5>
        </div>
    </div>
    <?php while ($row = $q2->fetch()) { ?>
        <a href="post.php<?php echo '?id=' . $row['id'] ?>" class="text-decoration-none text-dark">
            <div class="latest-news__content">
                <div class="row">
                    <div class="col">
                        <i class="bi bi-calendar"></i>
                        <span class="mt-2">
                            <?php 
                                $phpdate = strtotime($row['date']);
                                $mysqldate = date('H:i', $phpdate);
                                echo($mysqldate);    
                            ?>
                        </span>
                    </div>
                </div>
                <div class="row border-bottom pb-1 mb-3">
                    <div class="col">
                        <p class="m-0 fw-bold">
                            <?= htmlspecialchars($row['title']); ?>
                        </p>
                    </div>
                </div>
            </div>
        </a>
    <?php } ?>
</div>