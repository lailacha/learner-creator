<div class="col-md-12 flex course mt-5">

    <div class="col-md-6">
        <h1 class="mb-3 ">Edit <?php echo $course->getName() ?> </h1>


            <?php if (isset($form)) : ?>
                <?php echo $form ?>

            <?php endif; ?>
        <a href="/show/course?id=<?php echo $course->getId() ?>" >
            <button class="mt-2 ">Go back to course</button>
        </a>

    </div>

</div>
