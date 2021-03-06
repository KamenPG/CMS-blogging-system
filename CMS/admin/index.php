<?php include "includes/admin_header.php" ?>

    <div id="wrapper">

        <div id="page-wrapper">

          <?php

          $session = session_id();
          $time = time();
          $time_out_in_seconds = 60;
          $time_out = $time - $time_out_in_seconds;

          $query = "SELECT * FROM users_online WHERE session = '$session'";
          $send_query = mysqli_query($connection, $query);
          $count = mysqli_num_rows($send_query);

          if ($count == NULL) {
              mysqli_query($connection, "INSERT INTO users_online(session, times) VALUES('$session', '$time') ");
          } else {
              mysqli_query($connection, "UPDATE users_online SET times = '$time' WHERE session = '$session'");
          }

          $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE times > '$time_out'");
          $count_users = mysqli_num_rows($users_online_query);

           ?>

            <div class="container-fluid">

              <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">

                        <h1 class="page-header">
                            Welcome to admin !
                            <small><?php echo $_SESSION['username']?></small>
                        </h1>

                    </div>
                </div>
                <!-- /.row -->


         <!-- /.row -->

<div class="row">
<div class="col-lg-3 col-md-6">
 <div class="panel panel-primary">
     <div class="panel-heading">
         <div class="row">
             <div class="col-xs-3">
                 <i class="fa fa-file-text fa-5x"></i>
             </div>
             <div class="col-xs-9 text-right">

               <?php

               $query = "SELECT * FROM posts";
               $select_all_posts = mysqli_query($connection, $query);
               $count_posts = mysqli_num_rows($select_all_posts);

                ?>

           <div class='huge'><?php echo $count_posts ?></div>
                 <div>Posts</div>
             </div>
         </div>
     </div>
     <a href="posts.php">
         <div class="panel-footer">
             <span class="pull-left">View Details</span>
             <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
             <div class="clearfix"></div>
         </div>
     </a>
 </div>
</div>
<div class="col-lg-3 col-md-6">
 <div class="panel panel-green">
     <div class="panel-heading">
         <div class="row">
             <div class="col-xs-3">
                 <i class="fa fa-comments fa-5x"></i>
             </div>
             <div class="col-xs-9 text-right">

               <?php

               $query = "SELECT * FROM comments";
               $select_all_comments = mysqli_query($connection, $query);
               $count_comments = mysqli_num_rows($select_all_comments);

                ?>

              <div class='huge'><?php echo $count_comments ?></div>
               <div>Comments</div>
             </div>
         </div>
     </div>
     <a href="comments.php">
         <div class="panel-footer">
             <span class="pull-left">View Details</span>
             <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
             <div class="clearfix"></div>
         </div>
     </a>
 </div>
</div>
<div class="col-lg-3 col-md-6">
 <div class="panel panel-yellow">
     <div class="panel-heading">
         <div class="row">
             <div class="col-xs-3">
                 <i class="fa fa-user fa-5x"></i>
             </div>
             <div class="col-xs-9 text-right">

               <?php

               $query = "SELECT * FROM users";
               $select_all_users = mysqli_query($connection, $query);
               $count_users = mysqli_num_rows($select_all_users);

                ?>

             <div class='huge'><?php echo $count_users; ?></div>
                 <div> Users</div>
             </div>
         </div>
     </div>
     <a href="users.php">
         <div class="panel-footer">
             <span class="pull-left">View Details</span>
             <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
             <div class="clearfix"></div>
         </div>
     </a>
 </div>
</div>
<div class="col-lg-3 col-md-6">
 <div class="panel panel-red">
     <div class="panel-heading">
         <div class="row">
             <div class="col-xs-3">
                 <i class="fa fa-list fa-5x"></i>
             </div>
             <div class="col-xs-9 text-right">

               <?php

               $query = "SELECT * FROM categories";
               $select_all_categories = mysqli_query($connection, $query);
               $count_categories = mysqli_num_rows($select_all_categories);

                ?>

                 <div class='huge'><?php echo $count_categories; ?></div>
                  <div>Categories</div>
             </div>
         </div>
     </div>
     <a href="categories.php">
         <div class="panel-footer">
             <span class="pull-left">View Details</span>
             <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
             <div class="clearfix"></div>
         </div>
     </a>
 </div>
</div>
</div>
         <!-- /.row -->

         <div class="row">

           <div id="columnchart_material" style="width: 'auto'; height: 500px;">

             <?php

             $query = "SELECT * FROM posts WHERE post_status = 'draft'";
             $select_draft_posts = mysqli_query($connection, $query);
             $count_draft_posts = mysqli_num_rows($select_draft_posts);

             $query = "SELECT * FROM posts WHERE post_status = 'published'";
             $select_published_posts = mysqli_query($connection, $query);
             $count_publshed_posts = mysqli_num_rows($select_published_posts);

             $query = "SELECT * FROM comments WHERE content_status = 'unapproved'";
             $select_unapproved_comments = mysqli_query($connection, $query);
             $count_unapproved_comments = mysqli_num_rows($select_unapproved_comments);

             $query = "SELECT * FROM users WHERE user_role = 'admin'";
             $select_admin_users = mysqli_query($connection, $query);
             $count_admin_users = mysqli_num_rows($select_admin_users);

             $query = "SELECT * FROM users WHERE user_role = 'subscriber'";
             $select_sub_users = mysqli_query($connection, $query);
             $count_sub_users = mysqli_num_rows($select_sub_users);


              ?>



           </div>

           <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Count'],

          <?php

          $elements_text = ['Active Posts', 'Draft Posts', 'Posts', 'Pending Comments', 'Comments', 'Admins', 'Subsribers', 'Users', 'Categories'];

          $elements_count = [$count_publshed_posts, $count_draft_posts, $count_posts, $count_unapproved_comments, $count_comments, $count_admin_users, $count_sub_users, $count_users, $count_categories];

          for ($i=0; $i < 9 ; $i++) {
              echo "['{$elements_text[$i]}'" . "," . "{$elements_count[$i]}],";
          }

           ?>

        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

         </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include "includes/admin_footer.php" ?>
