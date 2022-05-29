
<div class="col-md-8">
    <?php if($user->getAvatar() !== 0): ?>
        <div class="col-md-5 avatar" >
            <img class="" style="height: 200px; " src="<?php echo $user->avatar(); ?>"  />
            <p> mail: &nbsp; <?php echo $user->getEmail() ?></p>
        </div>
    <?php endif; ?>
    <?php if (isset($form)) : ?>
        <?php echo $form ?>

    <?php endif; ?>
</div>
