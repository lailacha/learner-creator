<?php     $settings = \App\Model\Settings::getInstance(); ?>
<!DOCTYPE html>
<html lang="en" class="front">
<head>
    <meta charset="UTF-8">
    <title><?php echo $settings->getBy('id', 'site_name')->getValue() ?? "Learner" ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"
            defer></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="../../framework/dist/main.js"></script>
    <script src="https://kit.fontawesome.com/abaaf4d322.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js" charset="utf-8"></script>
    <script src="https://cdn.tiny.cloud/1/iam35x4cabb1nisnr71bcn2cpamtw3nk67uokoq3b288i0ay/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" type="text/css" href="../../framework/dist/main.css"/>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>
<style>
    :root{
    --sidebar-background-color: <?php echo $settings->getBy('id', 'sidebar_color')->getValue() ?>;
    --main-color: <?php echo $settings->getBy('id', 'main_color')->getValue() ?>;
    --big-title-size: <?php echo $settings->getBy('id', 'big_title_size')->getValue() ?>;
    --primary-color: <?php echo $settings->getBy('id', 'primary_color')->getValue() ?>;
    --main-font: <?php echo $settings->getBy('id', 'main_font')->getValue() ?>;
    }
</style>
<body class="flex grid">

    <section id="sidebar-left">
        <?php include "Partial/sidebar-left.partial.php"; ?>
    </section>

    <div class="container column w-100 pl-3 pr-3">

        <?php include "./View/Partial/error-message.partial.php"; ?>

        <?php include $this->view . ".view.php"; ?>

    </div>
    <?php if (\App\Core\Session::getInstance()->get('user')){
        include "Partial/sidebar-right.partial.php";
    } ?>



    <script src="https://code.iconify.design/2/2.1.2/iconify.min.js"></script>
    <script>

        $(document).ready(function () {
            $('#example').DataTable();
        });


        //toggle nav-link
        $('.nav-link').click(function () {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });
        /*  var ctx = document.getElementById('myChart').getContext("2d");

          var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
          gradientStroke.addColorStop(0, '#2F7DC0');

          var gradientFill = ctx.createLinearGradient(300, 0, 300, 200);
          gradientFill.addColorStop(0.6, "rgba(47, 118, 192, 0.8)");
          gradientFill.addColorStop(1, "rgba(59, 205, 179, 0.4)");

          var myChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                  datasets: [{
                      label: "Data",
                      borderColor: gradientStroke,
                      pointBorderColor: gradientStroke,
                      pointBackgroundColor: gradientStroke,
                      pointHoverBackgroundColor: gradientStroke,
                      pointHoverBorderColor: gradientStroke,
                      pointBorderWidth: 10,
                      pointHoverRadius: 10,
                      pointHoverBorderWidth: 1,
                      pointRadius: 3,
                      fill: true,
                      backgroundColor: gradientFill,
                      borderWidth: 4,
                      data: [3.3, 2.3, 1.9, 1.8, 1.9, 2.4, 2.7, 2.9, 3, 2.9, 2.7, 2.5],
                  }]
              },
              options: {
                  animation: {
                      easing: "easeInOutBack"
                  },
                  legend: {
                      display: false,
                  },
                  tooltips: {
                      callbacks: {
                          label: function (tooltipItem) {
                              return tooltipItem.yLabel;
                          }
                      }

                  },
                  scales: {
                      yAxes: [{
                          ticks: {
                              fontColor: "rgba(0,0,0,0.5)",
                              fontStyle: "bold",
                              beginAtZero: true,
                              maxTicksLimit: 5,
                              padding: 20
                          },
                          gridLines: {
                              drawTicks: false,
                              display: false
                          }

                      }],
                      xAxes: [{
                          gridLines: {
                              zeroLineColor: "transparent"
                          },
                          ticks: {
                              padding: 20,

                              fontColor: "rgba(0,0,0,0.5)",
                              fontStyle: "bold"
                          }
                      }]
                  }
              }
          });

      */
    </script>

</body>
</html>