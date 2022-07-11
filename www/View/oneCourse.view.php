
<div class="col-md-12 flex course">
    <div class="course-container col-md-8">
        <h1><?php echo $course->getName(); ?>
        <?php if($course->getUser() === \App\Model\User::getUserConnected()->getId()): ?>
            <a href="/edit/course?id=<?php echo $course->getId(); ?>"><i class="fas fa-edit"></i></a>
        <?php endif; ?>
        </h1>

        <label class="mt-5" for="">Description of the course:</label>
        <p><?php echo $course->getDescription(); ?></p>
        <label class="mt-5" for="">Category of the course:</label>
        <p><?php echo $course->getCategoryName(); ?></p>
        <a href="/saveLike?course=<?php echo $course->getId() ?>" class="mt-2 ml-2">
                <button>Like</button>
            </a>
        <img class="cover"  src="<?php echo $course->cover() ?>" alt="">
        <div class="flex">
            <a href="/createCourse" class="mt-2">
                <button>Go back to the course creator</button>
            </a>
            <a href="/createLesson?course_id=<?php echo $course->getId() ?>" class="mt-2 ml-2">
                <button>Create a lesson</button>
            </a>
        </div>

    </div>
    <div class="toggle-chapter col-md-2 flex jc-sb ai-center">
        <h3>Watchlist</h3>
        <i class="fas fa-angle-right"></i>
    </div>
    <div class="chapter-wrapper col-md-4">
            <div class="chapter-container p-1">
                <div class="col-md-12 flex jc-sb ai-center">
                <h2>Chapitres</h2>
                    <i class="fas fa-times"></i>

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
                <div class="flex column col-md-12 mt-2">
                    <a href="/create/chapter?course_id=<?php echo $course->getId() ?>">
                    <button class="">
                        Add a chapter</button>
                    </a>
                </div>

            </div>
            </div>



    </div>


</div>




<script>
    $('.toggle-description').hide();
    $('.toggle-chapter').hide();

    $('.lesson-container').click(function() {
        $(this).find('.toggle-description').toggle();
    });

    //close button should close chapter-container
    $('.fa-times').click(function() {
        $(".chapter-container").hide();
        $(".course-container").toggleClass("col-md-10");
        $(".chapter-wrapper").toggleClass("col-md-4");
        $('.toggle-chapter').show();

    });

    $('.toggle-chapter').click(function() {
        $(".chapter-container").show();
        $(".course-container").toggleClass("col-md-10");
        $(".chapter-wrapper").toggleClass("col-md-4");
        $('.toggle-chapter').hide();
    });



</script>

