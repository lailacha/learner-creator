<?php
/*** set the content type header ***/
/*** Without this header, it wont work ***/
header("Content-type: text/css");


$font_family = 'Arial, Helvetica, sans-serif';
$font_size = '0.7em';
$border = '1px solid';
$color= 'red';
?>

body {
    font-family: <?php echo $font_family; ?>;
    font-size: <?php echo $font_size; ?>;
    margin: 0;
    padding: 0;
    background-color: <?php echo $color; ?>;
}