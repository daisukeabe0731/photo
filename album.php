<?php
require_once 'functions.php';

$pdo = connectDB();
// var_dump($_POST);
// exit;

$image_id = $_POST['button'];
$personA = false;
if (isset($_POST['checkboxA'])) $personA = $_POST['checkboxA'];
$personB = false;
if (isset($_POST['checkboxB'])) $personB = $_POST['checkboxB'];
$personC = false;
if (isset($_POST['checkboxC'])) $personC = $_POST['checkboxC'];

// var_dump($personA);
// exit;

if ($personA) {
    $sql = 'INSERT INTO album(image_id, person_id)
                VALUES (:image_id, :person_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':image_id', $image_id, PDO::PARAM_STR);
    $stmt->bindValue(':person_id', $personA, PDO::PARAM_STR);
    $stmt->execute();
}

if ($personB) {
    $sql = 'INSERT INTO album(image_id, person_id)
                VALUES (:image_id, :person_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':image_id', $image_id, PDO::PARAM_STR);
    $stmt->bindValue(':person_id', $personB, PDO::PARAM_STR);
    $stmt->execute();
}

if ($personC) {
    $sql = 'INSERT INTO album(image_id, person_id)
                VALUES (:image_id, :person_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':image_id', $image_id, PDO::PARAM_STR);
    $stmt->bindValue(':person_id', $personC, PDO::PARAM_STR);
    $stmt->execute();
}


unset($pdo);
header('Location:catalog.php');
exit();


unset($pdo);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>Image Test</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <h4>画像一覧</h4>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 border-right">
                <ul class="list-unstyled">
                    <?php for ($i = 0; $i < count($images); $i++) : ?>
                        <li class="media mt-5">
                            <a href="#lightbox" data-toggle="modal" data-slide-to="<?= $i; ?>">
                                <img src="image.php?id=<?= $images[$i]['image_id']; ?>" width="100px" height="auto" class="mr-3">
                            </a>
                            <div class="media-body">
                                <h6><?= $images[$i]['image_name']; ?> (<?= number_format($images[$i]['image_size'] / 1000, 2); ?> KB)</h6>
                                <h6><?= $images[$i]['created_at']; ?></h6>
                                <a href="javascript:void(0);" onclick="var ok = confirm('削除しますか？'); if (ok) location.href='delete.php?id=<?= $images[$i]['image_id']; ?>'">
                                    <i class="far fa-trash-alt"></i> 削除</a>
                            </div>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>
            <div class="col-md-4 pt-4 pl-4">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>画像を選択</label>
                        <input type="file" name="image" required>
                    </div>
                    <button type="submit" class="btn btn-primary">保存</button>
                </form>
                <div class="person">
                    <a class="btn btn-primary" href="personA.php">person A</a>
                    <a class="btn btn-primary" href="personB.php">person B</a>
                    <a class="btn btn-primary" href="personB.php">person C</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal carousel slide" id="lightbox" tabindex="-1" role="dialog" data-ride="carousel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <ol class="carousel-indicators">
                        <?php for ($i = 0; $i < count($images); $i++) : ?>
                            <li data-target="#lightbox" data-slide-to="<?= $i; ?>" <?php if ($i == 0) echo 'class="active"'; ?>></li>
                        <?php endfor; ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php for ($i = 0; $i < count($images); $i++) : ?>
                            <div class="carousel-item <?php if ($i == 0) echo 'active'; ?>">
                                <img src="image.php?id=<?= $images[$i]['image_id']; ?>" class="d-block w-100">
                            </div>
                        <?php endfor; ?>
                    </div>
                    <a class="carousel-control-prev" href="#lightbox" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#lightbox" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>