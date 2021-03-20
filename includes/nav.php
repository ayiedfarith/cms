

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/project/cms/index">CMS</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                      <a class='dropdown-toggle' type='button' data-toggle='dropdown'><i class='fa fa-cogs'></i> Category
                      <span class='caret'></span></a>
                        <ul class='dropdown-menu'>
                    <?php 
                        $query = "SELECT DISTINCT posts.post_category_id, posts.post_status,";
                        $query .= " categories.cat_id, categories.cat_title ";
                        $query .= " FROM posts ";
                        $query .= " INNER JOIN categories ON posts.post_category_id =  categories.cat_id";  
                        $select_all_categories_query = query($query);  
                        $count = 0; 

                        while ($row = mysqli_fetch_assoc($select_all_categories_query)) { 
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        $post_status = $row['post_status'];

                        $category_class = '';
                        $registration_class = '';
                        $contact_class = '';

                        $pageName = basename($_SERVER['PHP_SELF']);
                        $registration = 'registration.php';
                        $contact = 'contact.php';

                        if(isset($_GET['category']) && $_GET['category'] == $cat_id )
                        {
                            $category_class = 'active';
                        } 
                        elseif ($pageName == $registration)
                        {
                            $registration_class = 'active';
                        }
                        elseif ($pageName == $contact)
                        {
                            $contact_class = 'active';
                        }
                        

                        if($post_status == 'Published')
                        {
                            echo "<li class='$category_class'><a  href='/project/cms/category/{$cat_id}'>{$cat_title}</a></li>"; 
                        }
                        elseif(!empty($post_status == 'Draft') || ($post_status == 'Draft') )
                        {
                            if($post_status == 'Published')
                            {
                                echo "<li class='$category_class'><a  href='/project/cms/category/{$cat_id}'>{$cat_title}</a></li>"; 
                            } 
                        }
                        else 
                        {
                            if($count < 1)
                            {
                                echo "<center><small class='text-info'>No Data</small></center>"; 
                                $count++;
                            }
                        }                                 
                        }           
                    ?>
                     </ul>
                    </li>
                    
                    <?php if(isLoggedIn()) :?>
                    <li>
                        <a href="/project/cms/admin/index"><?php echo currentRole(); ?></a> 
                    </li>
                    <li>
                        <a href="/project/cms/includes/logout.php">Logout</a> 
                    </li>
                    <?php else: ?>
                    <li>
                        <a href="/project/cms/login">Login</a> 
                    </li>
                    <?php endif; ?>

                    <li class="<?php echo $registration_class; ?>">
                        <a href="/project/cms/registration">Registration</a> 
                    </li>
                    <li  class="<?php echo $contact_class; ?>">
                        <a href="/project/cms/contact">Contact</a> 
                    </li>

                    <?php 
                    $pageName =  basename($_SERVER['PHP_SELF']);
                    $post = "post.php";

                    if($pageName == $post )
                    {
                        $the_post_id = $_GET['p_id'];
                        $user = currentUser();

                        $query = "SELECT * FROM posts WHERE post_id = {$the_post_id} ";
                        $select_post = mysqli_query($connection, $query);
                        confirmQuery($select_post);

                        $row = mysqli_fetch_assoc($select_post);
                        $post_user = $row['post_user'];

                         if (isset($_SESSION['user_role']) && $post_user === $user) {
                            
                            if(isset($the_post_id))
                            {
                                echo "<li><a href='/project/cms/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
                            }
                         } 
                    }

                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>