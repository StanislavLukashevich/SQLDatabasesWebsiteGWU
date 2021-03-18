<!-- Navigation -->
<?php
	require_once("utils.php");
?>
<nav class="navbar navbar-light bg-light static-top">
	<div class="container" id="navContainer">
		<button class="btn btn-primary" id="home"  onclick="window.location.replace('../php/home.php')">Home</button>
	<?php
		if (check_permissions(3)) {//applicants login	
	?>	
		<button class="btn btn-primary" id="appForm" onclick="loadForm('application.php')">My Application</button>
	<?php
		} else if (check_permissions(1) || check_permissions(6) || check_permissions(2)) {	//gs log in	
	?>	
		<button class="btn btn-primary" id="revForm" onclick="loadForm('applicants.php')">Review Applications</button>
	<?php
		}
	?>
	</div>	
</nav>
