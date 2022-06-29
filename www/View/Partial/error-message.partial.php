<?php if (isset($_SESSION["flash-message"]) and !isset($_SESSION["flash-message"]['bienvenue'])) : ?>

    <div class=" mt-2 flash-message <?php echo isset($_SESSION["flash-message"]["error"]) ? "error" : (isset($_SESSION["flash-message"]["success"]) ? "success" : "") ?>">
        <?php echo $_SESSION["flash-message"]["error"] ?? $_SESSION["flash-message"]["success"] ?? "" ?>
    </div>


<?php elseif (isset($_SESSION["flash-message"]['bienvenue'])) : ?>
    <?php include "bienvenue.partial.php" ?>


<?php unset($_SESSION["flash-message"]) ?>
<?php endif; ?>

