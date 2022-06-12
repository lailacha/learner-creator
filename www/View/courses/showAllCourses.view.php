<div class="col-md-12">
<!--    <table class=" dataTable display bg-white p-2" style="width:100%">-->
<!--        <thead>-->
<!--        <tr>-->
<!--            <th>Name</th>-->
<!--            <th>Category</th>-->
<!--            <th>Status</th>-->
<!--            <th>Actions</th>-->
<!--        </tr>-->
<!--        </thead>-->
<!--        <tbody>-->
<!--        --><?php //foreach ($courses as $course) : ?>
<!--            <tr>-->
<!---->
<!--                <td class="">--><?php //echo $course->getName() ?><!--</td>-->
<!--                <td class="">--><?php //echo $course->getCategoryName() ?><!--</td>-->
<!--                <td class="">Unverified</td>-->
<!--                <td><a href="/show/course?id=--><?php //echo $course->getId() ?><!--"><button class="icon bg-black p-0 rounded-2 ml-a"><i class="fas fa-light fa-eye white"></i></a>-->
<!--                    <a onclick="return confirm('are you sure to delete?');" href="/delete/course?id=--><?php //echo $course->getId() ?><!-- "><button class="icon bg-red ml-1 p-0 rounded-2"><i class="fas fa-light fa-trash white"></i></a>-->
<!--                </td>-->
<!--            </tr>-->
<!--        --><?php //endforeach; ?>
<!---->
<!--        </tbody>-->
<!--    </table>-->

    <div class="search-bar col-md-8 m-2">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search"/>

    </div>
    <section class="flex row search-results">
<!--        <?php /*foreach ($courses as $course) : */?>
            <div class="course-thumbnail col-md-3">
                <img class="cover"  src="<?php /*echo $course->cover() */?>" alt="">
                <p class=""><?php /*echo $course->getName() */?></p>
                <a href="/show/course?id=<?php /*echo $course->getId() */?>"></a>
                <a onclick="return confirm('are you sure to delete?');" href="/delete/course?id=<?php /*echo $course->getId() */?> "></i></a>
            </div>
        --><?php /*endforeach; */?>

    </section>

</div>

