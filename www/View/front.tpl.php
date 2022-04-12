<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title??"Titre par défaut" ?></title>
    <link rel="stylesheet" type="text/css" href="../../framework/dist/main.css"/>
    <meta name="description" content="ceci est une super page">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <header>
    <div class="container clearfix">
				<a href="#" class="vertically-centered">
					<img src="framework/assets/images/" alt="Logo Schills">
				</a>
				<nav>
					<ul class="clearfix" >
						<li><a href="#">Home</a></li>
						<li><a href="#">Offer Ressource</a></li>
						<li><a href="#">Log in</a></li>
						<li><a href="#">Contact</a></li>
						
					</ul>
				</nav>
			</div>
    </header>


    <?php include $this->view.".View.php";?>

</body>
</html>