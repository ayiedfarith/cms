<?php 

    include("delete_modal.php");

    //this post global is for making sure, that the bulk options that user pick for the post status could be updated here  
    if(isset($_POST['checkBoxArray']))
    {
        foreach ($_POST['checkBoxArray'] as $postValueId) {
            $bulk_options = escape($_POST['bulk_options']);

            switch ($bulk_options) {
                case 'Published':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                    
                    $update_to_published_status = mysqli_query($connection, $query);
                     confirmQuery($update_to_published_status);
                    break;

                case 'Draft':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                    
                    $update_to_draft_status = mysqli_query($connection, $query);
                     confirmQuery($update_to_draft_status);
                    break;

                case 'delete':

                    $query = "DELETE FROM posts WHERE post_id = {$postValueId} ";
                    $update_to_delete_status = mysqli_query($connection, $query);
                    confirmQuery($update_to_delete_status);
                    break;  

                case 'clone':

                    $query = "SELECT * FROM posts WHERE post_id = {$postValueId} ";
                    $select_post_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_array($select_post_query)) {
                        $post_user = escape($row['post_user']);
                        $post_title = escape($row['post_title']);
                        $post_category_id = escape($row['post_category_id']);
                        $post_status = escape($row['post_status']);
                        $post_image = $row['post_image'];
                        $post_tag = escape($row['post_tag']);
                        $post_date = escape($row['post_date']);
                        $post_content = escape($row['post_content']);
                    }

                    $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tag,  post_status) ";

                    $query .= "VALUES({$post_category_id},'$post_title','$post_user', now(),'{$post_image}','{$post_content}','{$post_tag}','{$post_status}')";

                    $copy_query = mysqli_query($connection, $query);
                    confirmQuery($copy_query);
                    break;  


                case 'reset':
                    $query = "UPDATE posts SET post_view_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $postValueId) . "";
                    $reset_views_count = mysqli_query($connection, $query);
                     confirmQuery($reset_views_count);
                    break;                

            }
        }
    }

 ?>

<form action="" method="post">
<table class="table table-bordered table-hover table-sm ">


    <div id="bulkOptionsContainer" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="Published">Publish</option>
            <option value="Draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
            <option value="reset">Reset Views Count</option>
        </select>
    </div>

    <div id="bulkOptionsButton" class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success " value="Apply" title="Apply Bulk Action">
        <a class="btn btn-primary" href="posts.php?source=add_post" title="Add New Post"><i class="fa fa-plus"></i> Add New</a>
    </div> <br>


    <thead>
        <tr>
            <th><input  type="checkbox" id="selectAllBoxes" name="selectAllBoxes"></th>
            <th>Id</th>
            <th>Author (Users)</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>Views Count</th>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>

    <?php

    //find all posts query

     // $query = "SELECT * FROM posts ORDER BY post_id DESC"; 
     $query = "SELECT posts.post_id, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
     $query .= "posts.post_tag, posts.post_comment_count, posts.post_date, posts.post_view_count, categories.cat_id, categories.cat_title ";
     $query .= " FROM posts ";
     $query .= " LEFT JOIN categories ON posts.post_category_id =  categories.cat_id";


     $select_posts = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_posts)) 
    { //amek and tukarkan column kepada key, and anak2 column as value dia s
        $post_id = $row['post_id'];
        $post_user = $row['post_user'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tag = $row['post_tag'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_view_count = $row['post_view_count'];
        $category_id = $row['cat_id'];
        $category_title = $row['cat_title'];



        echo "<tr>";
        ?>
            <td><input class="checkBoxes" type="checkbox"  name="checkBoxArray[]" value="<?php echo $post_id ?>"></td>
        <?php
        echo "<td> $post_id </td>";


        echo "<td> $post_user </td>";
        


        echo "<td> $post_title </td>";



        //THIS ONE WILL RELATE THE POST CATEGORY ID FROM TABLE POST WITH CAT ID IN TABLE CATEGORIES
         // $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
         // $select_categories_id = mysqli_query($connection, $query); 

         // while ($row = mysqli_fetch_assoc( $select_categories_id )) { 
         // $cat_id = escape($row['cat_id']);
         // $cat_title = escape($row['cat_title']);

         //  echo "<td> {$cat_title} </td>";

         // }
        echo "<td> {$category_title} </td>";

        echo "<td> $post_status </td>";
        echo "<td><img class='img-responsive' width='100' src='../images/$post_image' alt='images'>  </td>";
        echo "<td> $post_tag </td>";

        // This is to preview comment count for each post, by using mysqli num rows function
        $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
        $send_comment_query = mysqli_query($connection, $query);

        $row = mysqli_fetch_array($send_comment_query);
        $comment_id = isset($row['comment_id']);
        $count_comments = mysqli_num_rows($send_comment_query);

        //
        
        echo "<td> <i class='fa fa-comments'></i><a href='post_comments.php?id=$post_id'> $count_comments</a> </td>";




        echo "<td> $post_date</td>";
        echo "<td> <i class='fa fa-user'></i> <a href='posts.php?reset={$post_id}'>$post_view_count</a> </td>";

        //source=edit_post is to get user go to the edit post page, while p_id = post id is to stored the the id of the post, & is used if u wanted to set more than one parameter when using $_GET 
       echo "<td>
                 <div class='dropdown'>
                  <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'><i class='fa fa-cogs'></i> Action
                  <span class='caret'></span></button>
                  <ul class='dropdown-menu'>
                    <li><a href='../post.php?p_id={$post_id}' title='View Post'> <i class='fa fa-eye'></i> View</a></li>
                    <li class='divider'></li>
                    <li><a  href='posts.php?source=edit_post&p_id={$post_id}' title='Edit Post'><i class='fa fa-pencil'></i> Edit</a></li>
                    <li class='divider'></li>";

        ?>
            <form method="post">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">

                <?php  
                echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>';
                 ?>
            </form>
        <?php

        //echo "<li><a rel='$post_id' href='javascript:void(0)' class='delete_link' title='Delete Post'><i class='fa fa-trash'></i> Delete</a></li>"
        echo " </ul>
                </div> 
                  </td>
                    </tr>";



    }
    ?> 


        </tbody>
    </table>
    </form>

<?php 

if (isset($_POST['delete'])) {

    if(isset($_SESSION['user_role']))
    {
        if($_SESSION['user_role'] == 'Admin')
        {
            $the_post_id =  escape( $_POST['post_id']);


            $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
            $deleteQuery = mysqli_query($connection, $query);

            if(!$deleteQuery)
            {
                die('QUERY FAILED' . mysqli_error($connection));
            }


             header("Location: posts.php");       
        }
    }

}

if (isset($_GET['reset'])) {

    if(isset($_SESSION['user_role']))
    {
        if($_SESSION['user_role'] == 'Admin')
        {

            $the_post_id =  escape( $_GET['reset']);


            $query = "UPDATE posts SET post_view_count = 0 WHERE post_id =" . escape($the_post_id) . "";
            $resetQuery = mysqli_query($connection, $query);

            if(!$resetQuery)
            {
                die('QUERY FAILED' . mysqli_error($connection));
            }


             header("Location: posts.php");
        }
    }

}
 ?>

<script>

    $(document).ready(function(){

        $(".delete_link").on('click', function(){

            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete=" + id + " ";


            $(".modal_delete_link").attr("href", delete_url); 

            $("#delModal").modal("show")
        });
    });

</script>