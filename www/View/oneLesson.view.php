
<section class="col-md-12 flex course">
    <div class="course-wrapper col-md-8">
        <div class="bg-primary p-1 breadcrumb">
            <h3 class="white m-0"><?php echo $lesson->course()->getName()." > ".$lesson->chapter()->getName()." > ".$lesson->getTitle(); ?> </h3>
        </div>
        <div class="flex jc-sb ai-center jc-center">
        <h1 class="flex"><?php echo $lesson->getTitle(); ?>
            <?php if($lesson->getUser() === (\App\Model\User::getUserConnected()->getId())  || \App\Model\User::getUserConnected()->getRoleId() === 3) : ?>
                <a href="/edit/lesson?lesson_id=<?php echo $lesson->getId(); ?>"><i class="fas fa-edit"></i></a>
            <?php endif; ?>

        </h1>
        <input type="checkbox" name="progress" id="progress" <?php echo $progressState ? "checked" : "unchecked" ?>/>
        </div>
        <?php if(isset($video)): ?>
            <video class="w-100" preload="auto" autoplay="" loop="" muted="" controls>
                <source src="<?php echo $video  ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        <?php endif; ?>
        <div class="text-container mt-2">
            <label class="mt-5" for="">Cours textuel:</label>
            <p><?php echo $lesson->getText(); ?></p>
        </div>
        <div class="flex column">
            <p class="mb-0"> Author: <?php echo $lesson->user()->fullname(); ?></p>
            <p>Date: <?php echo $lesson->getCreatedAt(); ?></p>
        </div>
    
        <?php if($settings->getBy('id', 'allow_comment')->getValue() === "true"): ?>
                <div class="flex row">
                <?php if (isset($form)) : ?>
                    <?php echo $form ?>
    
                <?php endif; ?>
            </div>
            <?php include "./View/Partial/showComments.partial.php";
        endif; ?>

        <div class="flex">
            <a href="/show/course?id=<?php echo $lesson->course()->getId() ?>" class="mt-2">
                <button>Go back to the course</button>
            </a>
            <a href="/createLesson?course_id=<?php echo $lesson->course()->getId() ?>" class="mt-2 ml-2">
                <button>Create a new lesson</button>
            </a>
            <?php if(\App\Model\User::getUserConnected()->getRoleId() === 3 ): ?>
                <a href="/delete/lesson?lesson_id=<?php echo $lesson->getId() ?>" class="mt-2 ml-a">
                    <button class="error">Remove lesson</button>
                </a>
            <?php endif; ?>
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
            <?php foreach ($lesson->course()->getChapters() as $chapter) : ?>
                <hr>
                <div class="lesson-container col-md-12">

                    <div class="col-md-12 flex jc-sb ai-center">
                        <i class=" fa-solid fa-chevron-right"></i>

                        <h3><?php echo $chapter->getName(); ?></h3>
                        <div class>
                            <i class="icon fa fa-eye"></i>
                            <?php if($lesson->getUser() === (\App\Model\User::getUserConnected()->getId())  || \App\Model\User::getUserConnected()->getRoleId() === 3) : ?>
                            <a href="/createLesson?course_id=<?php echo $lesson->course()->getId() ?>"> <i class="fa-solid fa-plus"></i> </a>
                            <?php endif; ?>
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
                <a href="/create/chapter?course_id=<?php echo $lesson->course()->getId() ?>">
                    <button class="">
                        Add a chapter</button>
                </a>
            </div>
        </div>
    </div>
</section>
<script>

    $('#progress').change(function() {
        console.log('Progress') ;
        $.ajax({
            url: "/store/progress",
            method: "POST",
            data: {
                lesson_id: <?php echo $lesson->getId() ?>,
                user_id: <?php echo \App\Model\User::getUserConnected()->getId() ?>,
                progress: $('#progress').is(':checked')
            },
            success: function(data) {
                console.log(data);
            }
    })
    });

    $('.toggle-description').hide();
    $('.toggle-chapter').hide();

    $('.chapter-container').click(function() {
        $(this).find('.toggle-description').toggle();
    });

    //close button should close chapter-container
    $('.fa-times').click(function() {
        $(".chapter-container").hide();
        $(".course-wrapper").toggleClass("col-md-10");
        $(".chapter-wrapper").toggleClass("col-md-4");
        $('.toggle-chapter').show();

    });

    $('.toggle-chapter').click(function() {
        $(".chapter-container").show();
        $(".course-wrapper").toggleClass("col-md-10");
        $(".chapter-wrapper").toggleClass("col-md-4");
        $('.toggle-chapter').hide();
    });



</script>

