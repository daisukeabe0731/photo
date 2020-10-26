<?php
require_once 'functions.php';

$pdo = connectDB();
// var_dump($_POST);
// exit;

// SELECT文を変数に格納
$sql = 'SELECT * FROM `album` WHERE person_id = 1';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':album_id', (int)$_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$person = $stmt->fetch();

header('Content-type: ' . $image['image_type']);
echo $image['image_content'];

unset($pdo);
exit();
