<!DOCTYPE html>
<html lang="fr" class="vitrine">

<head>
    <meta charset="UTF-8">
    <title>Dashboard front</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"
            defer></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="../../framework/dist/main.js"></script>
    <script src="https://kit.fontawesome.com/abaaf4d322.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js" charset="utf-8"></script>
    <script src="https://cdn.tiny.cloud/1/iam35x4cabb1nisnr71bcn2cpamtw3nk67uokoq3b288i0ay/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" type="text/css" href="../../framework/dist/main.css"/>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
<header>
    <div class="container clearfix">
        <a href="/" class="vertically-centered">
            <img src="../../framework/assets/images/Schills__2_-removebg-preview 1.png" alt="Logo SCHILLS">
        </a>
        <nav>
            <ul class="clearfix">
                <li><a href="/">Home</a></li>
                <li><a href="#">Offer ressource</a></li>
                <li><a href="/login">Log in</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </nav>
    </div>
</header>
<div class="wrapper fadeInDown">

    <?php include "Partial/error-message.partial.php"; ?>

    <?php include $this->view . ".view.php"; ?>
</div>





<footer>
    <div class="container clearfix">
        <nav>
            <ul class="clearfix">
                <li><a href="#">Privacy Notice</a></li>
                <li><a href="#">Term of use</a></li>

            </ul>
        </nav>
        <small class="vertically-centered">© 2022 SCHILLS</small>
    </div>
</footer>
</body>

</html>
    