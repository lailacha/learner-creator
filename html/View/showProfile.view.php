
    <section id="profile-infos" class="flex row ">
        <div class="col-md-10 bg-white">
            <div class="flex row">
                <div class="col-md-4">
                    <img class="" style="height: 200px; " src="<?php echo $user->avatar(); ?>"  />
                </div>
                <div class="col-md-4">
                    <div class="mt-2">
                        <p>Firstname: </p>
                        <h2><?php echo $user->getFirstname(); ?></h2>
                    </div>
                    <div class="mt-2">
                        <p>Lastname: </p>
                        <h2><?php echo $user->getLastname(); ?></h2>
                    </div>
                    <div class="mt-2">
                        <p>Mail: </p>
                        <h2><?php echo $user->getEmail(); ?></h2>
                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <p>Statut:</p>
                    <h2>Learner</h2>
                    <!--        //TODO add userPermission-->
                    <a href="" class="">
                        <button class="error">Remove User</button>
                    </a>
                </div>

            </div>
        </div>

    </section>
            <h1>His courses</h1>
    <section id="courses-list" class="mt-4 col-md-8 flex-wrap bg-white" >

            <?php foreach ($courses as $course): ?>
            <div class="courses-list-container">
                <img class="cover"  src="<?php echo $course->cover() ?>" alt="">
                <a href="/show/course?id=<?php echo $course->getId() ?>"> <?php echo $course->getName(); ?></a>
            </div>
            <?php endforeach; ?>

            <p> </p>
    </section>
