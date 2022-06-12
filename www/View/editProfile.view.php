<div class="col-md-8">
    <?php if ($user->getAvatar() !== 0):?>
        <div class="col-md-5 avatar">
            <img class="" style="height: 200px; " src="<?php echo $user->avatar(); ?>"/>
            <p> mail: &nbsp; <?php echo $user->getEmail() ?></p>
        </div>
    <?php endif; ?>
<div class="flex">
    <div class="col-md-5">
        <?php if (isset($form)) : ?>
            <?php echo $form ?>

        <?php endif; ?>
    </div>
    <div class="col-md-5 col-offset-md-2">
        <h3>Création date</h3>
        <p>15/10/2000</p>
        <h3>Type of account </h3>
        <p>Learner</p>
    </div>

    <a href="/teacher/new" class="btn-secondary">Faire une demande pour devenir professeur chez nous</a>
</div>
