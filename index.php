<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<?php

require __DIR__ . './../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try{

    $pdo = new PDO(
        'mysql:host='. $_ENV['DB_HOST'] . ';dbname='. $_ENV['DB_DATABASE'],
        $_ENV['DB_USER'], $_ENV['DB_PASS']
    );

    $sql = "SELECT title, body, author, image, date, shortBody, id
        FROM news
        ORDER BY id DESC";

    $q = $pdo->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);

    
    $sql2 = "SELECT title, date, image, shortBody, id
        FROM news
        ORDER BY id DESC";
    
    $q2 = $pdo->query($sql2);
    $q2->setFetchMode(PDO::FETCH_ASSOC);

    $sql3 = "SELECT title, date, image, shortBody, id
        FROM news
        ORDER BY id DESC LIMIT 1";
    
    $q3 = $pdo->query($sql3);
    $q3->setFetchMode(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>

<?php include('./inc/header.php') ?>
<?php include('./inc/navbar.php') ?>

    <!-- Last News Section -->
    <div class="px-4">
        <div class="row d-flex justify-content-between">
            <div class="col-lg-9">
                <!-- Main Img Blok -->
                <div class="main-news border rounded bg-light">
                    <?php while ($row = $q3->fetch()){ ?>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="main-news__img">
                                        <?php echo("<img class='main-img img-fluid' style='' alt='img' src=\"./images/{$row['image']}\"  >") ?> 
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 ms-2 m-sm-0">
                                    <div class="main__news__content my-2">
                                        <a href="post.php<?= '?id=' . $row['id']; ?>" class="row text-decoration-none text-dark">
                                            <div class="d-block">
                                                <div class="main-content__date">
                                                    <i class="bi bi-calendar-month-fill"></i>
                                                    <span class="">
                                                        <?php
                                                            $phpdate = strtotime($row['date']);
                                                            $mysqldate = date('H:i/d.m.Y', $phpdate);
                                                            echo($mysqldate);
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="main-content__title">
                                                    <h4 class="main__news__title fw-bold my-3 pe-1">
                                                        <?= htmlspecialchars($row['title']); ?>
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="main-content__description">
                                                    <p class="pe-2">
                                                    <?= htmlspecialchars($row['shortBody']); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    <?php } ?>
                </div>
                <!-- Double News Blok -->
                <div class="row mt-4">
                    <!--Grid column-->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ul class="d-flex flex-wrap list-unstyled mb-0">
                            <?php while ($row = $q->fetch()) { ?>
                                <li class="justify-content-between mb-2" style="width: 350px;">
                                    <a href="post.php<?= '?id=' . $row['id'];?>" class="row text-decoration-none text-dark">
                                        <div class="col-md-4 col-sm-5 col-4 mx-auto twice-img">
                                            <?php echo("<img style='max-width: 120px;' alt='img' src=\"./images/{$row['image']}\"  >") ?>
                                        </div>
                                        <div class="col-md-8 col-sm-6 col-8 date-text">
                                            <div class="d-flex date-time">
                                                <i class="bi bi-calendar3"></i>
                                                <span class="ms-2">
                                                    <?php
                                                        $phpdate = strtotime($row['date']);
                                                        $mysqldate = date('H:i', $phpdate);
                                                        echo($mysqldate);
                                                    ?>
                                                </span>
                                            </div>
                                            <p style="width: 100%; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">
                                                <?= htmlspecialchars($row['title']); ?>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

            </div>
            <?php include('./inc/latest-news.php') ?>
        </div>
    </div>

<?php include('./inc/footer.php'); ?>