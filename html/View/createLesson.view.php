
<div class="col-md-12 mt-5 flex">


        <div class="flex column col-md-5 jc-center">
    <h1 class="mb-3 ">Create a Lesson</h1>

            <?php if (isset($form)) : ?>
                <?php echo $form ?>

            <?php endif; ?>
        </div>

    <div class="flex column col-md-5 col-offset-md-1">
        <h1 class="mb-3 ">Create a Chapter</h1>

        <?php if (isset($formChapter)) : ?>
            <?php echo $formChapter ?>

        <?php endif; ?>
    </div>

</div>


