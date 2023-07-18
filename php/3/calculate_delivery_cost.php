<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}

$city = $_POST['city'];
$weight = $_POST['weight'];

$url = 'http://exercise.develop.maximaster.ru/service/delivery/?city=' . urlencode($city) . '&weight=' . urlencode($weight);
$response = file_get_contents($url);

header('Content-Type: application/json');
echo $response;
