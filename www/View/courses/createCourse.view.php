
        <div class="col-md-12 mt-5">

          <div class="row">

              <div class="flex column col-lg-6 jc-center">
                  <h1 class="mb-2 ">Create a course</h1>


                  <?php if (isset($form)) : ?>
                      <?php echo $form ?>

                  <?php endif; ?>
              </div>
              <div class="col-lg-6">
                  <h2>My waiting courses requests</h2>
                  <table class=" dataTable display bg-white p-2" style="width:100%">
                      <thead>
                      <tr>
                          <th>Name</th>
                          <th>Category</th>
                          <th>Status</th>
                          <th>Actions</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($allCourses as $course) : ?>
                      <tr>

                                  <td class=""><?php echo $course->getName() ?></td>
                                  <td class=""><?php echo $course->getCategoryName() ?></td>
                          <td class="">Unverified</td>
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
<!--        <div class="hamburger col-xs-2">-->
<!--            <span class="bar"></span>-->
<!--            <span class="bar"></span>-->
<!--            <span class="bar"></span>-->
<!--        </div>-->
