<?php
require_once 'functions.php';

$pdo = connectDB();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // 画像を取得
    $sql = 'SELECT * FROM imageby ORDER BY created_at DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $images = $stmt->fetchAll();
} else {
    // 画像を保存
    if (!empty($_FILES['image']['name'])) {
        $name = $_FILES['image']['name'];
        $type = $_FILES['image']['type'];
        $content = file_get_contents($_FILES['image']['tmp_name']);
        $size = $_FILES['image']['size'];

        $sql = 'INSERT INTO imageby(image_name, image_type, image_content, image_size, created_at)
                VALUES (:image_name, :image_type, :image_content, :image_size, now())';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':image_name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':image_type', $type, PDO::PARAM_STR);
        $stmt->bindValue(':image_content', $content, PDO::PARAM_STR);
        $stmt->bindValue(':image_size', $size, PDO::PARAM_INT);
        $stmt->execute();
    }
    unset($pdo);
    header('Location:list.php');
    exit();
}

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
    <h4>写真振り分け</h4>

    <div class="person">
        <a href="list.php" class="btn btn-primary">画像アップロード</a>
        <a class="btn btn-primary" href="personA.php">Aさんフォルダ</a>
        <a class="btn btn-primary" href="personB.php">Bさんフォルダ</a>
        <a class="btn btn-primary" href="personC.php">Cさんフォルダ</a>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div>
                <ul class="list-unstyled">
                    <?php for ($i = 0; $i < count($images); $i++) : ?>
                        <li class="media mt-5">
                            <a href="#lightbox" data-toggle="modal" data-slide-to="<?= $i; ?>">
                                <img src="image.php?id=<?= $images[$i]['image_id']; ?>" width="100px" height="auto" class="mr-3">
                            </a>
                            <div class="media-body">
                                <!-- <h7><?= $images[$i]['image_name']; ?> (<?= number_format($images[$i]['image_size'] / 1000, 2); ?> KB)</h7><br> -->
                                <h7><?= $images[$i]['created_at']; ?></h7><br>

                                <form method="post" action="album.php">
                                    <label><input type="checkbox" name="checkboxA" value="1"> Aさん　</label>
                                    <label><input type="checkbox" name="checkboxB" value="2"> Bさん　</label>
                                    <label><input type="checkbox" name="checkboxC" value="3"> Cさん　</label>
                                    <button type="submit" name="button" value="<?= $images[$i]['image_id']; ?>">登録する</button>
                                </form>

                                <a href="javascript:void(0);" onclick="var ok = confirm('削除しますか？'); if (ok) location.href='delete.php?id=<?= $images[$i]['image_id']; ?>'">
                                    <br><i class="far fa-trash-alt"></i> 削除</a>
                            </div>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>
            <!-- <div class="col-md-4 pt-4 pl-4">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>画像を選択</label>
                        <input type="file" name="image" required>
                    </div>
                    <button type="submit" class="btn btn-primary">保存</button>
                </form> -->

            <!-- </div> -->
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