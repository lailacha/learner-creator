
<div class="col-md-10">
    <?php if($user->getAvatar() !== 0): ?>
        <div class="col-md-5 avatar" >
            <img class="" style="height: 200px; " src="<?php echo $user->avatar(); ?>"  />
            <p> mail: &nbsp; <?php echo $user->getEmail() ?></p>
           
        </div>
    <?php endif; ?>
    <?php if (isset($form)) : ?>
        <?php echo $form ?>

    <?php endif; ?>

    <a href="/add/teacher" class="btn-secondary">Faire une demande pour devenir professeur chez nous</a>
    
</div>
<div class="col-md-10">
    <?php if (isset($formCat)) : ?>
        <?php echo $formCat ?>

    <?php endif; ?>
    
         <?php foreach ($categoriesNumb as $value) : ?>
            <?php $cat = $value['category'];
            
        $categoryPref = $categories->getBy('id', $cat);
        echo $categoryPref->getName(); ?> <a href="/delete/catpref?category=<?php echo $categoryPref->getId() ?>">
        <input type="image" src="../framework/assets/images/delete.png" height="10" width="10"/>
         </a> <br>
       
    <?php endforeach; ?>  


    

    
</div>
