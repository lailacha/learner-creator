<h2>Candidat <?= $request->getUser()->getFirstname()." ".$request->getUser()->getLastname() ?></h2>

<section class="bg-white">
    <p>Statut : <?= $request->getStatut() === 1 ? "Valid" : ($request->getStatut() === 0 ? "Non Valid" : "Refusé") ?></p>
    <p>Theme :<?= $request->getTheme() ?></p>
    <p>Dernier Diplome :<?= $request->getDiplome() ?></p>
    <p>Motivation :<?= $request->getMotivation() ?></p>
    <p>CV : <a class="button" href="/download?id=<?= $request->getCv() ?>">Télécharger son cv</a></p>


    <p>
        <?php if ($request->getStatut() === 0) : ?>
            <a class="button" href="/valid/requestTeacher?id=<?= $request->getId() ?>">Valider</a>
            <a class="button" href="/refuse/requestTeacher?id=<?= $request->getId() ?>">Refuser</a>
        <?php endif; ?>
    </p>
</section>

<style>
    section {
        padding: 20px;
        border: 1px solid #ccc;
    }
</style>
