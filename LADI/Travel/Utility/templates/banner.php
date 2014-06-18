<div class="banner">
<h2>CDE Travel Manager</h2>
<div class="menu_wrapper">

    <nav class="menu">
		<?php
		$myRank = $_SESSION[$SV_RANK];
		
		echo('
			<a href="/Travel/Request/addRequestForm.php" id="firstLink">Submit a Request</a>
			<a href="/Travel/Request/viewAllRequestsForm.php">View Requests</a>
			');
		if($myRank >= 1)
		{	
		echo('
			<a href="/Travel/User/viewAllUsersForm.php">Manage Users</a>
			<a href="/Travel/Item/viewAllItemsForm.php">Manage Items</a>
			<a href="/Travel/SetupType/viewAllSetupTypesForm.php">Manage Setup Types</a>
			');
		}
		
		?>
    </nav>
</div>


<?php
if(isset($_SESSION[$SV_USERNAME]))
{//Begin info bar
?>

<div class="info_bar">
    <div class="info_wrapper">
        <span class="float_right">
            <span>Signed in as <?php echo $_SESSION[$SV_USERNAME];?></span>
            <span><a href="/Travel/Password/changePasswordForm.php">Change Password</a></span>
            <span><a href="/Travel/logout.php">Logout</a></span>
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

</div>