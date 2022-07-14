
<div class="col-md-12 mt-5">
    <h1 class="mb-3 ">My courses</h1>

    <div class="flex">
        <div class="col-md-6">
            <table id="" class=" dataTable display bg-white p-2" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($courses as $course) : ?>
                    <tr>

                        <td class=""><?php echo $course->getName() ?></td>
                        <td class=""><?php echo $course->getCategoryName() ?></td>
                        <td class=""><?php echo $course->getStatus() === 0 ? "unverified" : "verified" ?></td>
                        <td><a href="/show/course?id=<?php echo $course->getId() ?>"><button class="icon bg-black p-0 rounded-2 ml-a"><i class="fas fa-light fa-eye white"></i></a>
                            <a onclick="return confirm('are you sure to delete?');" href="/delete/course?id=<?php echo $course->getId() ?> "><button class="icon bg-red ml-1 p-0 rounded-2"><i class="fas fa-light fa-trash white"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>

</div>
<script>
    $('#example').DataTable();

    const dialog = document.querySelector('.modal');
    document.getElementById('show').onclick = function() { dialog.show();
        body.style.filter = "blur(5px)";
    };
    document.getElementById('hide').onclick = function() { dialog.close();
    };
</script>
