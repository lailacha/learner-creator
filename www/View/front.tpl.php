<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title??"Titre par défaut" ?></title>
    <link rel="stylesheet" type="text/css" href="framework/dist/main.css"/>
    <meta name="description" content="ceci est une super page">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<!-- TODO create flash message error system
<?php /*if (isset($_SESSION["error"])) : */?>
<div class="message error">
<p> <?php /*echo $_SESSION["error"] */?></p>
</div>
<?php /*endif */?>
<?php /*if (isset($_SESSION["success"])) : */?>
    <div class="message success">
        <p> <?php /*echo $_SESSION["success"] */?></p>
    </div>
--><?php /*endif */?>

    <?php include $this->view.".View.php";?>

</body>
</html>