<h1 class="mb-3">Les catégories de cours</h1>
 <div class="col-md-8">
    <?php foreach ($categories as $categorie) : ?>
             <a class="d-block mb-1" href="/show/category?category_id=<?php echo $categorie->getId() ?>"><?php echo $categorie->getName() ?></a>
    <?php endforeach; ?>

 </div>
