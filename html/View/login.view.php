    <div id="formContent">
        <h2 class="active"> Sign In </h2>

        <h2><a class="inactive underlineHover" href="/register">Sign Up</a></h2>


        <?php if (isset($form)) : ?>
            <?php echo $form ?>

        <?php endif; ?>


        <div id="formFooter">
            <a class="underlineHover" href="/recoverPassword">Forgot Password?</a>
        </div>

    </div>
