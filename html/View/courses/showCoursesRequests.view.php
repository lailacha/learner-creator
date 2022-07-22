<h1>Unpublish courses</h1>
<div class="col-md-12">
        <table class=" dataTable display bg-white p-2" style="width:100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Professor</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($courses as $course) : ?>
                <tr>

                    <td class=""><?php echo $course->getName() ?></td>
                    <td class=""><?php echo $course->getCategoryName() ?></td>
                    <td class=""><?php echo $course->getDescription() ?></td>
                    <td class=""><?php echo $course->firstname." ".$course->lastname?></td>
                    <td class="flex"><a href="/show/course?id=<?php echo $course->getId() ?>"><button class="icon bg-black p-0 rounded-2 ml-a"><i class="fas fa-light fa-eye white"></i></a>
                        <a onclick="return confirm('are you sure to validate course?');" href="/verify/course?course_id=<?php echo $course->getId() ?> "><button class="icon ml-1 p-0 rounded-2 bg-primary"><i class="fas fa-solid fa-circle-check"></i></a>
                        <a onclick="return confirm('are you sure to reject course?');" href="/delete/course?id=<?php echo $course->getId() ?> "><button class="icon bg-red ml-1 p-0 rounded-2"><i class="fas fa-light fa-trash "></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>

    </div>

