<?php

$counterFile = 'counter.txt';

$counter = (int)file_get_contents($counterFile);
$counter++;
file_put_contents($counterFile, $counter);

$currentTime = date('H:i');

echo 'Страница была загружена ' . $counter . ' раз. Текущее время ' . $currentTime . '.';
