                        <table class="table table-bordered table-hover table-sm ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>email</th>
                                    <th>Role</th>
                                    <th colspan="3">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

    //find all posts query

     $query = "SELECT * FROM users "; //select all from table posts 
     $select_users= mysqli_query($connection, $query); //mysqli_query() use to simplify the use of performing query to db

    while ($row = mysqli_fetch_assoc($select_users)) 
    { //amek and tukarkan column kepada key, and anak2 column as value dia s
        $user_id = $row['user_id'];
        $Username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        


        echo "<tr>";
        echo "<td> $user_id  </td>";
        echo "<td> $Username </td>";
        echo "<td> $user_firstname </td>";



        //THIS ONE WILL RELATE THE POST CATEGORY ID FROM TABLE POST WITH CAT ID IN TABLE CATEGORIES
        //  $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
        //  $select_categories_id = mysqli_query($connection, $query); 

        //  while ($row = mysqli_fetch_assoc( $select_categories_id )) { 
        //  $cat_id = $row['cat_id'];
        //  $cat_title = $row['cat_title'];






        // echo "<td> {$cat_title} </td>";

        // }

        echo "<td> $user_lastname </td>";
        echo "<td> $user_email </td>";
        echo "<td> $user_role </td>";

        // $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
        // $select_post_id_query = mysqli_query($connection, $query);

        // while ($row = mysqli_fetch_assoc($select_post_id_query)) {
        //     $post_id = $row['post_id'];
        //     $post_title = $row['post_title'];

        //     echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";

        // }

        


        //source=edit_post is to get user go to the edit post page, while p_id = post id is to stored the the id of the post, & is used if u wanted to set more than one parameter when using $_GET 
        echo "<td><a href='comments.php?approve='> <button class='btn btn-success'><i class='fa fa-check'></i> Approve</button></a></td>";
        echo "<td><a href='comments.php?unapprove='> <button class='btn btn-warning'><i class='fa fa-times'></i> Unapproved</button></a></td>";
        echo "<td><a href='comments.php?delete='> <button class='btn btn-danger'><i class='fa fa-trash'></i> Delete</button></a></td>";
        echo "</tr>";


    }
                                  ?> 

                            </tbody>
                        </table>


<?php 
if (isset($_GET['approve'])) { //dia hantar comment id; using get, approve=$comment_id same goes for unapproved so dia simpan value comment id kt dalam $_get approve & unapprove
        $the_comment_id = $_GET['approve'];


        $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = $the_comment_id   ";
        $approve_comment_query = mysqli_query($connection, $query);

        if(!$approve_comment_query)
        {
            die('QUERY FAILED' . mysqli_error($connection));
        }


        header("Location: comments.php");
    }





if (isset($_GET['unapprove'])) {
        $the_comment_id = $_GET['unapprove'];


        $query = "UPDATE comments SET comment_status = 'Unapproved'  WHERE comment_id = $the_comment_id  ";
        $unapprove_comment_query = mysqli_query($connection, $query);

        if(!$unapprove_comment_query)
        {
            die('QUERY FAILED' . mysqli_error($connection));
        }


        header("Location: comments.php");
    }







if (isset($_GET['delete'])) {
        $the_comment_id = $_GET['delete'];


        $query = "DELETE FROM  comments WHERE comment_id = {$the_comment_id} ";
        $deleteQuery = mysqli_query($connection, $query);

        if(!$deleteQuery)
        {
            die('QUERY FAILED' . mysqli_error($connection));
        }


        header("Location: comments.php");
    }





 ?>