<?php

$message = "";
$result = "";

if (isset($_POST['create_post'])) {

  $post_title = $_POST['title'];
  $post_author = $_POST['author'];
  $post_category_id = $_POST['post_category'];
  $post_status = $_POST['post_status'];

  $post_image = $_FILES['post_image']['name'];
  $post_image_temp = $_FILES['post_image']['tmp_name'];

  $post_tags = $_POST['post_tags'];
  $post_content = str_replace('\'','\'\'',$_POST['post_content']);
  $post_date = date('d-m-y');

  if (!empty($post_title) && !empty($post_author) && !empty($post_category_id) && !empty($post_status) && !empty($post_image) && !empty($post_image_temp) && !empty($post_tags) && !empty($post_content)) {


            move_uploaded_file($post_image_temp,"../images/$post_image");

            $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date,
            post_image, post_content, post_tags, post_status )";

            $query .="VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),
            '{$post_image}','{$post_content}','{$post_tags}','{$post_status}' )";

            $create_post_query = mysqli_query($connection, $query);

            confirmQuery($create_post_query);

            $the_post_id = mysqli_insert_id($connection);

            $message = "Post Created</strong>: <a href='../post_admin.php?p_id={$the_post_id}'>View Post</a>";
            $result = "success";
  }

  else {
    $message = "Fields cannot be empty!";
    $result = "danger";
  }
}
 ?>

<form action="" method="post" enctype="multipart/form-data">

  <h4><div class=bg-<?php echo $result ?>><strong><?php echo $message?></strong></div></h4>


  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="title">
  </div>

  <div class="form-group">
    <label for="categories">Categories</label>
    <select name="post_category" id="">
      <?php
          $query = "SELECT * FROM categories";
          $select_categories= mysqli_query($connection, $query);

          confirmQuery($select_categories);

          while ($row = mysqli_fetch_assoc($select_categories)) {
          $cat_id = $row['cat_id'];
          $cat_title = $row['cat_title'];

          echo "<option value='$cat_id'>$cat_title</option>";
          }
       ?>
    </select>
  </div>

  <div class="form-group">

    <div class="form-group">
      <label for="post_tags">Post Tags</label>
      <input type="text" class="form-control" name="post_tags">
    </div>

  <div class="form-group">
    <label for="post_author">Author</label>
    <input type="text" class="form-control" name="author" value="<?php echo $_SESSION['username']?>" readonly>
  </div>

  <div class="form-group">
    <select class="" name="post_status">
      <option value="draft">Post Status</option>
      <option value="published">Publish</option>
      <option value="draft">Draft</option>
    </select>
  </div>

  <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" name="post_image">
  </div>

  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" class="form-control" name="post_tags">
  </div>

  <div class="form-group">
    <label for="post_content">Post Content</label>

    <textarea class="form-control" name="post_content" id="body" rows="30" cols="50"></textarea>
    <?php include './scripts.js' ?>

  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_post"  value="Publish Post">
  </div>

</form>
