<?php
if(isset($_SESSION[$SV_USERNAME]))
{//Begin info bar
?>
<div class="info_bar">
<div class="info_wrapper">


<span class="floatRight">



	<span>Signed in as <?php echo $_SESSION[$SV_USERNAME];?></span>



<span><a href="/Coskrey/Password/changePasswordForm.php">Change Password</a></span>
<span><a href="/Coskrey/logout.php">Logout</a></span>
</span>

</div>
</div>

<?php 
}	//End the info bar



//We're also including error messages.

if(isset($_SESSION[$SV_ERROR]))
{
	echo("<div class=\"error_box\">" . htmlspecialchars($_SESSION[$SV_ERROR]) . "</div>");
	unset($_SESSION[$SV_ERROR]);
}

if(isset($_SESSION[$SV_MESSAGE]))
{
	echo("<div class=\"message_box\">" . htmlspecialchars($_SESSION[$SV_MESSAGE]) . "</div>");
	unset($_SESSION[$SV_MESSAGE]);
}
?>
