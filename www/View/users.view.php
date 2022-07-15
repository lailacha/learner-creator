<h2>Users</h2>
<table class=" dataTable display bg-white p-2" style="width:100%">
    <thead>
    <tr>
        <th>Nom Complet</th>
        <th>Email</th>
        <th>Role</th>
        <th>Status de compte</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($listUsers as $user) : ?>
        <tr>
            <td><?= $user->getLastname()?> <?= $user->getFirstname() ?></td>
            <td><?= $user->getEmail()?></td>
            <td><?= $user->getRole()?></td>
            <td><?= $user->getStatus() === 1 ? "Valid" : "Non valid"?></td>

            <td class="action">
                <a class="button" href="/delete/user?user_id=<?= $user->getId() ?>">Delete</a>
                <a class="button" href="/edit/user?user_id=<?= $user->getId() ?>">Editer</a>
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