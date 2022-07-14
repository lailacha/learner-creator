<div class="col-md-12">
    <div class="row">
    <div class="search-bar col-md-8 m-2">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" />

    </div>
    <button onclick="location.href='/categories';" class="col-md-3 bg-primary rounded-25  ">
            <h2 class="white">Search by category</h2>
        </button>
    <section class="flex row search-results">
        <!--        <?php /*foreach ($courses as $course) : */ ?>
            <div class="course-thumbnail col-md-3">
                <img class="cover"  src="<?php /*echo $course->cover() */ ?>" alt="">
                <p class=""><?php /*echo $course->getName() */ ?></p>
                <a href="/show/course?id=<?php /*echo $course->getId() */ ?>"></a>
                <a onclick="return confirm('are you sure to delete?');" href="/delete/course?id=<?php /*echo $course->getId() */ ?> "></i></a>
            </div>
        --><?php /*endforeach; */ ?>

    </section>
      

</div>
</div>