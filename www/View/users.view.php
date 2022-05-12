<?php

?>
<table>
    <thead>
    <tr>
        <th>Nom Complet</th>
        <th>Email</th>
        <th>Status de compte</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($listUsers as $user) : ?>
        <tr>
            <td><?= $user['lastname']?> <?= $user['firstname'] ?></td>
            <td><?= $user['email']?></td>
            <td><?= $user['status'] == 1 ? "Valid" : "Non valid"?></td>

            <td class="action">

                <form action="" method="post">
                    <input type="hidden" name="_method" id="" value="edit" >
                    <input type="hidden" name="id_user" id="" value="<?= $user['id'] ?>" >
                    <input type="submit" name="editer" value="editer" class="button edit" id="">
                </form>

                <form action="" method="post">
                    <input type="hidden" name="_method" id="" value="delete" >
                    <input type="hidden" name="id_user" id="" value="<?= $user['id'] ?>" >
                    <input type="submit" name="delete" value="delete" class="button delete" id="">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>







    </tbody>

</table>



<style>

    td,th{
        padding: 0 10px;
    }
    .action{
        display: flex;
    }
    .action > a{
        margin: 0 10px;

    }
</style>