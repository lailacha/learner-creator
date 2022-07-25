<?php

    $servername = "localhost";
    $username = "root";
    $password = "rootiw3";
    $dbname = "mvcdocker2";
    $conn = new mysqli($servername, $username, $password, $dbname);

    $links = $conn->query("SELECT id, updated_at FROM esgi_course");

    $base_url = "https://learner-creator.online/show/course?id=";

    header("Content-Type: application/xml; charset=utf-8");
    echo '<?xml version="1.0" encoding="UTF-8" ?>' . PHP_EOL;
    echo '<urlset xmlns="http://www.google.com/schemas/sitemap/0.84" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">' . PHP_EOL;
    
    while ($link = $links->fetch_assoc()) {
        $datetime = new DateTime($link['updated_at']);
        $date_final = $datetime->format('Y-m-d\TH:i:sP');

        echo '<url>' . PHP_EOL;
        echo '<loc>'. $base_url . $link['id'] .'/</loc>' . PHP_EOL;
        echo '<lastmod>'. $date_final .'</lastmod>' . PHP_EOL;
        echo '<changefreq>daily</changefreq>' . PHP_EOL;
        echo '</url>' . PHP_EOL;
    }
    echo '</urlset>' . PHP_EOL;
?>