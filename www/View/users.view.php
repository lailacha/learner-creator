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
                <a class="button view">view</a>
                <a class="button delete" href="<?= $_SERVER['REQUEST_URI']."/delete?id=".$user['id']?>">Delete</a>
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