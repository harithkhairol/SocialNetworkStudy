<?php 
require_once("../php_includes/db_con.php");

//This block deletes all acounts that do not activate after 3 days

$sql = "SELECT id, username FROM users WHERE signup<=CURRENT_DATE - INTERVAL 3 DAY AND activated='0'";

$query = mysqli_query($db_con, $sql);
$numrows = mysqli_num_rows($query);

if($numrows>0){
	while($row= mysqli_fetch_array($query, MYSQLI_ASSOC)){

		$id = $row['id'];
		$username = $row['username'];
		$userFolder = "../user/$username";

		if (is_dir($userFolder)){
			rmdir($userFolder);
		}

		$sql = "DELETE FROM users WHERE id='$id' AND username='$username' AND activated='0' LIMIT 1";
		$query = mysqli_query($db_con,$sql);
		$sql = "DELETE FROM useroptions WHERE username='$username' LIMIT 1";
		$query = mysqli_query($db_con,$sql);

	}
}

?>