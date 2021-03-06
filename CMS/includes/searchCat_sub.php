<?php

if (isset($_POST['submit'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
    $tags  = mysqli_query($connection, $query);
    if (! $tags) {
        die("error" . mysqli_error($connection));
    } else {
        $count = mysqli_num_rows($tags);
        if ($count == 0) {
            echo "<h1>NO POSTS</h1>";
        } else {
            while ($row = mysqli_fetch_assoc($tags)) {
                $post_title   = $row['post_title'];
                $post_id      = $row['post_id'];
                $post_content = $row['post_content'];
                $post_date    = $row['post_date'];
                $post_author  = $row['post_author'];
                $post_image   = $row['post_image']; ?>

<!-- First Blog Post -->
<h2>
<a href="post_sub.php"><?php echo $post_title ?></a>
</h2>
<p class="lead">
by <a href="author_posts_sub.php"><?php echo $post_author ?></a>
</p>
<p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
<hr>
<img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
<hr>
<p><?php echo $post_content ?></p>
<a class="btn btn-primary" href="post_sub.php">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

<hr>

<?php
            } // end of while ($row = mysqli_fetch_assoc($tags))
        } // closing else of if ($count == 0) {
    } // closing else of if(!$tags)
} else {
    if (isset($_GET['category'])) {
        $post_category_id = $_GET['category'];
    }

    $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id";
    $select_all_posts_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = substr($row['post_content'], 0, 300); ?>

  <!-- First Blog Post -->
  <h2>
      <a href="post_sub.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
  </h2>
  <p class="lead">
      by <a href="author_posts_sub.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id ?>"><?php echo $post_author ?></a>
  </p>
  <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
  <hr>
  <a href="post_sub.php?p_id=<?php echo $post_id ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""></a>
  <hr>
  <p><?php echo $post_content ?></p>
  <a class="btn btn-primary" href="post_sub.php">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

  <hr>

<?php
    }
} ?>
