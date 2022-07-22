<h1>Edition des catégories</h1>

<?php
if(isset($form)) {
    echo $form;
} ?>

<div class="col-md-12">
        <table class=" dataTable display bg-white p-2" style="width:100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
              
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $categorie): ?>
                <tr>

                    <td class=""><?php echo $categorie->getName() ?></td>
                    <td class=""><?php echo $categorie->getDescription() ?></td>
                    <td class="flex">
                    <a href="/edit/category?category_id=<?php echo $categorie->getId(); ?>"><button class="icon bg-violet ml-1 p-0 rounded-2"><i class="fas fa-light fa-edit "></i></a>

                        <a onclick="return confirm('are you sure to reject categorie?');" href="/delete/category?id=<?php echo $categorie->getId() ?> "><button class="icon bg-red ml-1 p-0 rounded-2"><i class="fas fa-light fa-trash "></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>

    </div>