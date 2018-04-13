<?php 
include_once("php_includes/check_login_status.php");
$sql = "SELECT username, avatar FROM users WHERE avatar IS NOT NULL AND activated='1' ORDER BY RAND() LIMIT 32";
$query = mysqli_query($db_con, $sql);
$userlist = "";

while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){


	$u = $row["username"];
	$avatar = $row["avatar"];
	$profile_pic = 'user/'.$u.'/'.$avatar;
	$userlist .= '<a href="user.php?u='.$u.'" title="'.$u.'"><img src="'.$profile_pic.'" alt="'.$u.'" style="width:100px; height:100px; margin:10px;"></a>';
}

$sql = "SELECT COUNT(id) FROM users WHERE activated='1'";
$query = mysqli_query($db_con, $sql);
$row = mysqli_fetch_row($query);
$usercount = $row[0];

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Social Network</title>
<link rel="icon" href="favicon.ico" type="images/x-icon">
<link rel="stylesheet" href="style/style.css">
<script src="js/main.js"></script>
</head>
<body>
<?php include_once("template_pageTop.php"); ?>

<div id="pageMiddle">

<p style="padding: 24px; width:500px; line-height: 1.5em;">Social Network bla bla bla </p>

<h3>Total Users: <?php echo $usercount; ?></h3>
<h3>Random People Chosen From Database That Have Uploaded Their Avatar </h3>
<?php echo $userlist; ?>


</div>

<?php include_once("template_pageBottom.php"); ?>


</body>
</html>
