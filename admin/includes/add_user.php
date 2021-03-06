  <?php 

if (isset($_POST['create_user'])) {


	$user_firstname = escape($_POST['user_firstname']);
	$user_lastname = escape($_POST['user_lastname']);
	$user_role = escape($_POST['user_role']);

	//user superglobal $_FILES to send data thru post
	// $post_image = $_FILES['image']['name']; // image the name of the file 
	// $post_image_temp = $_FILES['image']['tmp_name']; // temporary info of the files, when previewing the name of the file, this also needed to be transfer

	$username = escape($_POST['username']);
	$user_email = escape($_POST['user_email']);
	$user_password = escape($_POST['user_password']);
	// $post_date = date('d-m-y'); //using default date function, with a format to capture date


	// move_uploaded_file($post_image_temp, "../images/$post_image"); //to move file to the desired location in query below it only stored the file name not its location.

	$password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

	$query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) ";

	$query .= "VALUES('{$user_firstname}','{$user_lastname}','${user_role}', '{$username}','{$user_email}','{$password}')"; //stored the latest date using now() function

	$create_user_query = mysqli_query($connection, $query);

	 confirmQuery($create_user_query);
		 echo "<div class='alert alert-success '>";
		 echo "User Created Successful " . " " . "(<a href='users.php'>View User Detail</a>)";
		 echo "</div>";

}




 ?>

<!-- enctype multipart/form-data is require if u want to send file thru post-->
<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="user_firstname">First Name</label>
		<input type="text" class="form-control" name="user_firstname" placeholder="Enter First Name" required>
	</div>

	<div class="form-group">
		<label for="user_lastname">Last Name</label>
		<input type="text" class="form-control" name="user_lastname" id="user_lastname" placeholder="Enter Last Name" required>
	</div>

	<div class="form-group">
		<label for="user_role">Role</label>
		<select name="user_role" id="user_role" class="form-control">
			<option value="Subscriber">Select Options..</option>
			<option value="Admin">Admin</option>
			<option value="Subscriber">Subscriber</option>
		</select>
	</div>



	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" class="form-control" name="username" id="username" placeholder="Enter Username" required>
	</div>

	<div class="form-group">
		<label for="post_tags">Email</label>
		<input type="email" class="form-control" name="user_email" id="user_email" placeholder="example@gmail.com" required>
	</div>

	<div class="form-group">
		<label for="post_tags">Password</label>
		<input type="password" class="form-control" name="user_password" id="user_password" placeholder="Enter Password" required>
	</div>


	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_user" value="Create User">
	</div>

</form>