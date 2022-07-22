    <div id="formContent">
        <h2><a class="inactive underlineHover" href="/login">Sign In</a></h2>
        <h2 class="active"> Sign Up </h2>


        <?php if (isset($form)) : ?>
            <?php echo $form ?>

        <?php endif; ?>


        <div id="formFooter">
            <a class="underlineHover" href="/recoverPassword">Forgot Password?</a>
        </div>
    </div>
