<div class="banner">
<h2>CDE Budget Request Manager</h2>



<div class="menu_wrapper">

    <nav class="menu">
        <a href="/Budget/Request/addRequestForm.php" id="firstLink">Submit a Request</a>
        <a href="/Budget/Request/viewAllRequestsForm.php">View Requests</a>
        <a href="/Budget/Request/viewPendingRequestsForm.php">Pending Requests</a>
        <a href="/Budget/User/viewAllUsersForm.php">Manage Users</a>
        <a href="/Budget/FinAccount/viewAllFinAccountsForm.php">Manage Finance Accounts</a>
        <a href="/Budget/Vendor/viewAllVendorsForm.php">Manage Vendor List</a>
    </nav>
</div>


<?php
if(isset($_SESSION[$SV_USERNAME]))
{//Begin info bar
?>

<div class="info_bar">
    <div class="info_wrapper">
        <span class="float_right">
            <span>Signed in as <?php echo $_SESSION[$SV_USERNAME] . ": " . $_SESSION[$SV_RANK];?></span>
            <span><a href="/Budget/Password/changePasswordForm.php">Change Password</a></span>
            <span><a href="/Budget/logout.php">Logout</a></span>
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