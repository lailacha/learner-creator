<div class="col-md-12 flex course mt-5">

    <div class="col-md-6">
        <h1 class="mb-3 ">Edit <?php echo $lesson->getTitle() ?> </h1>


        <?php if (isset($form)) : ?>
            <?php echo $form ?>

        <?php endif; ?>
        <a href="/show/lesson?id=<?php echo $lesson->getId() ?>" >
            <button class="mt-2 ">Go back to Lesson</button>
        </a>

    </div>

</div>
