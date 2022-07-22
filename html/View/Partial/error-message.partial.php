<?php if(isset($_SESSION["flash-message"])): ?>
    <div class=" mt-2 flash-message <?php  echo isset($_SESSION["flash-message"]["error"]) ? "error" : (isset($_SESSION["flash-message"]["success"]) ? "success" : "") ?>">
        <?php  echo $_SESSION["flash-message"]["error"] ?? $_SESSION["flash-message"]["success"] ?? "" ?>
        <?php unset($_SESSION["flash-message"])?>
    </div>
<?php endif; ?>