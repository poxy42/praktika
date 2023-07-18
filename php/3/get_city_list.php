<?php
$cacheFile = 'city_list_cache.txt';
$cacheLifetime = 86400; // 24 часа

if (file_exists($cacheFile) && time() - filemtime($cacheFile) < $cacheLifetime) {
    $cityList = file_get_contents($cacheFile);
} else {
    $cityList = file_get_contents('http://exercise.develop.maximaster.ru/service/city/');
    file_put_contents($cacheFile, $cityList);
}

header('Content-Type: application/json');
echo $cityList;
