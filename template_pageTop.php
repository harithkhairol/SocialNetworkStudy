<?php

include_once("php_includes/check_login_status.php");

// It is important for any file that includes this file, to have
// check_login_status.php included at its very top.



$envelope = '<img src="images/note_dead.png" width="22" height="22" alt="Notes" title="This envelope is for logged in members" style="	margin-bottom:-7px" >';
$loginLink = '<a href="login.php">Log In</a> &nbsp; | &nbsp; <a href="signup.php">Sign Up</a>';
if($user_ok == true) {
	$sql = "SELECT notescheck FROM users WHERE username='$log_username' LIMIT 1";
	$query = mysqli_query($db_con, $sql);
	$row = mysqli_fetch_row($query);
	$notescheck = $row[0];
	$sql = "SELECT id FROM notifications WHERE username='$log_username' AND date_time > '$notescheck' LIMIT 1";
	$query = mysqli_query($db_con, $sql);
	$numrows = mysqli_num_rows($query);
    if ($numrows == 0) {
		$envelope = '<a href="notifications.php" title="Your notifications and friend requests"><img src="images/note_dead.png" width="22" height="22" alt="Notes" style="	margin-bottom:-7px" ></a>';
    } else {
		$envelope = '<a href="notifications.php" title="You have new notifications"><img src="images/note_flash.gif" width="22" height="22" alt="Notes" style="	margin-bottom:-7px"></a>';
	}
    $loginLink = '<a href="user.php?u='.$log_username.'">'.$log_username.'</a> &nbsp; | &nbsp; <a href="logout.php">Log Out</a>';
}
?>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<div id="pageTop">
  <div id="pageTopWrap">
    <div id="pageTopLogo">
      
<a href="http://localhost/SocialNetwork/user.php"><img src="images/logo.png" alt="logo"  height=90px title="Social Network" ></a>

      </a>
    </div>
    <div id="pageTopRest">
      <div id="menu1">

        <div>
 <?php 

if(isset($_GET["u"])){
	echo $envelope ; echo "&nbsp"; echo "&nbsp"; echo $loginLink; 
} else {
	echo $loginLink; 
}



          ?>



        </div>



      </div>
      <div id="menu2">
        <div>
		<a href="http://localhost/SocialNetwork/user.php"><img src="images/home.png" alt="home"  height=25px title="Home" style="	margin-top:-8px" > </a>
          <!--<a href="#">Menu_Item_1</a>
          <a href="#">Menu_Item_2</a> -->
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
 
 function load_unseen_notification(view = '')
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
    $('.dropdown-menu').html(data.notification);
    if(data.unseen_notification > 0)
    {
     $('.count').html(data.unseen_notification);
    }
   }
  });
 }
 
 load_unseen_notification();
 
 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  if($('#subject').val() != '' && $('#comment').val() != '')
  {
   var form_data = $(this).serialize();
   $.ajax({
    url:"insert.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     $('#comment_form')[0].reset();
     load_unseen_notification();
    }
   });
  }
  else
  {
   alert("Both Fields are Required");
  }
 });
 
 $(document).on('click', '.dropdown-toggle', function(){
  $('.count').html('');
  load_unseen_notification('yes');
 });
 
 setInterval(function(){ 
  load_unseen_notification();; 
 }, 5000);
 
});
</script>