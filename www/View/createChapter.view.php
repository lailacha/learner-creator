<div class="col-md-12 mt-5 flex">
    <div class="flex column col-md-5 ">
        <h1 class=""><?php echo $course->getName() ?></h1>
        <h1 class="mb-1 ">Create a Chapter</h1>

        <?php if (isset($form)) : ?>
            <?php echo $form ?>

        <?php endif; ?>
    </div>
    <div class="chapter-wrapper col-md-6 col-offset-md-2">
        <div class="chapter-container p-1">
            <div class="col-md-12 flex jc-sb ai-center">
                <h2>Chapitres</h2>
            </div>
            <?php foreach ($course->getChapters() as $chapter) : ?>
                <hr>
                <div class="lesson-container col-md-12">

                    <div class="col-md-12 flex jc-sb ai-center">
                        <i class=" fa-solid fa-chevron-right"></i>

                        <h3><?php echo $chapter->getName(); ?></h3>
                        <div class>
                            <i class="icon fa fa-eye"></i>
                            <a href="/createLesson?course_id=<?php echo $course->getId() ?>"> <i class="fa-solid fa-plus"></i> </a>
                        </div>
                    </div>

                    <div class="toggle-description">
                        <p><?php echo $chapter->getDescription(); ?></p>

                        <div class="flex column col-md-12">
                            <?php foreach ($chapter->getLessons() as $lesson) : ?>
                                <div class="lesson-container flex jc-sb ai-center">
                                    <h3 class=""><?php echo $lesson->getTitle(); ?></h3>
                                    <a href="/show/lesson?lesson_id=<?php echo $lesson->getId() ?>" <i class="fa-solid fa-play"></i> </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>


            <?php endforeach; ?>

        </div>
    </div>


</div>


<script>
    $('.toggle-description').hide();
    $('.toggle-chapter').hide();

    $('.lesson-container').click(function() {
        $(this).find('.toggle-description').toggle();
    });



    $('.toggle-chapter').click(function() {
        $(".chapter-container").show();
        $(".course-container").toggleClass("col-md-10");
        $(".chapter-wrapper").toggleClass("col-md-4");
        $('.toggle-chapter').hide();
    });



</script>
