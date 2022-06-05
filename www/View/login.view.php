<div class="container flex jc-center">
    <div class="flex ai-center jc-center column form-register">
        <h1>Se connecter</h1>

        <?php if (isset($form)) : ?>
            <?php echo $form ?>

        <?php endif; ?>
    </div>

    <div>
        <span>
            <a href="/register">Pas encore de compte ? S'inscrire</a>
        </span>

        <span>
            <a href="/recoverPassword">Mot de passe oublié ?</a>
        </span>
    </div>

    <!--  <form action="?" method="POST">
          <div class="g-recaptcha" data-sitekey="6LdqSEAeAAAAAIrfjm8MfW03lxfTzmxiyVcWuSgy"></div>
          <br/>
          <input type="submit" value="Submit">
      </form>-->
</div>

