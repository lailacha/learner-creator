<h2>Professor requests</h2>
<table class=" dataTable display bg-white p-2" style="width:100%">
    <thead>
    <tr>
        <th>Nom complet</th>
        <th>Email</th>
        <th>Theme</th>
        <th>Statut</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($listRequestsTeacher as $item) : ?>

        <tr>
            <td><?= $item->getUser()->getFirstname()?> <?= $item->getUser()->getLastname() ?></td>
            <td><?=$item->getUser()->getEmail() ?></td>
            <td><?= $item->getTheme() ?></td>
            <td><?= $item->getStatut() === 1 ? "Valid" : ($item->getStatut() === 0 ? "Non Valid" : "Refusé") ?></td>

            <td class="action">
                <a class="button" href="/show/requestTeacher?id=<?= $item->getId() ?>">Voir en detail</a>
                <a class="button" href="/refuse/requestTeacher?id=<?= $item->getId() ?>">Refuser</a>

            </td>
        </tr>
    <?php endforeach; ?>


    </tbody>

</table>


<style>

    td, th {
        padding: 0 10px;
    }

    .action {
        display: flex;
    }

    .action > a {
        margin: 0 10px;

    }
</style>