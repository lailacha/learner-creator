<?php

?>


<section>
    <div>Statut : <?= $request->getStatut() === 1 ? "Valid" : ($request->getStatut() === 0 ? "Non Valid" : "Refusé") ?></div>
    <div>Theme :<?= $request->getTheme() ?></div>
    <div>Dernier Diplome :<?= $request->getDiplome() ?></div>
    <div>Motivation :<?= $request->getMotivation() ?></div>
    <div>CV : <a class="button" href="/download?id=<?= $request->getCv() ?>">Télécharger son cv</a></div>


    <div>
        <?php if ($request->getStatut() === 0) : ?>
            <a class="button" href="/valid/requestTeacher?id=<?= $request->getId() ?>">Valider</a>
            <a class="button" href="/refuse/requestTeacher?id=<?= $request->getId() ?>">Refuser</a>
        <?php endif; ?>
    </div>
</section>
