<?php
	session_start();
	$username = $_POST['username'];
	$date_created = date('Y-m-d H:i:s');
	// connecting to database
	$conn = mysqli_connect("localhost", "root", "", "bot") or die("Database Error");
	//checking user query to database query
	$check_data = "INSERT INTO users (username, date_created) VALUES ('$username', '$date_created')";
	$run_query = mysqli_query($conn, $check_data) or die("Error");
	$last_id = mysqli_insert_id($conn);
	$_SESSION['username'] = $username;
	$_SESSION['user_id'] = $last_id;
	header("location: bot.php");
	exit();
?>