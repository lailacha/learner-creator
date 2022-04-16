<div class="flash-message <?php  echo isset($_SESSION["error"]) ? "error" : (isset($_SESSION["success"]) ? "success" : "") ?>">
<p><?php echo \App\Core\Session::get("error") ?? App\Core\Session::get("success") ?? "" ?> </p>
</div>