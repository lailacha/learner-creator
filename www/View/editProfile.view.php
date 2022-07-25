<div class="col-md-10">
    <?php include "Partial/bienvenue.partial.php"; ?>

    <div class="flex" style="margin: 15px 0">
        <div class="col-md-5" id="form_edit_profil">

            <?php if (isset($form)) : ?>
                <?php echo $form ?>

            <?php endif; ?>
        </div>
        <div class="col-md-5 col-offset-md-2">
                <div id="container_user_info">
                    <h3>Type of account </h3>
                    <p><?php echo \App\Model\User::getUserConnected()->getRole() ?></p>
                </div>


                <div id="container_add_pref">
                    <h2>Mes préférences : </h2>
                    <?php if (isset($formCat)) : ?>
                        <?php echo $formCat ?>

                    <?php endif; ?>
                </div>




                <table class="dataTable display bg-white p-2" style="width:100%">

                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($categoriesNumb

                                   as $value) : ?>
                        <tr>
                            <td>
                                <?php $cat = $value['category'];
                                $categoryPref = $categories->getBy('id', $cat);
                                echo $categoryPref->getName(); ?>
                            </td>
                            <td>
                                <a href="/delete/catpref?category=<?php echo $categoryPref->getId() ?>" class="btn-secondary--small">
                                        Supprimer
<!--                                    <img src="../framework/assets/images/delete.png" style="width: 10px">-->
                                </a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                    </tbody>
                </table>

        </div>


    </div>

    <div class="center">

        <?php if ($user->getRoleId() == 1): ?>

            <a href="/teacher/new" class="btn-secondary">Faire une demande pour devenir professeur chez nous</a>

        <?php endif; ?>
    </div>

</div>

