
    <h1>My profile</h1>
<div class="col-md-6 profile-card">
    <?php if($user->getAvatar() !== 0): ?>
        <div class="col-md-5 avatar" >
            <img class="" src="<?php echo $user->avatar(); ?>"  />
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

</div>
    <a href="/add/teacher">Faire une demande pour devenir professeur chez nous</a>
</div>
