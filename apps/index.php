<?php
	if (!isset($_SESSION)) {
		session_start();
		$_SESSION["created"] = True;
	}
	require_once('appvars.php');
	require_once('includes/utils.php');
	require_once('includes/header.php');

	# temporary automatic sign in
	// $_SESSION["id"] = 44444444;
?>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
	<div class="site-section" id="content">
	</div>
</body>

<?php require_once('includes/footer.php'); ?>

<script>
	function loadForm (url){
		// Using simpler jQuery ajax method for loading pages
		loadFormToContainer(url, $("#content"));
	}

	function loadFormToContainer(url, container) {
		container.load(url, function(responseText, statusText, jqXHR) {
			console.log(statusText, "loading", url);
		})
	}

	function viewLetter(letterID) {
        window.open("./reviewForms/viewLetter.php?letterID="+letterID, resizeable=true, width=200, height=200);
    }

    <?php
    	if (check_permissions(3)) {
    		echo "loadForm('application.php')";
    	} else if (check_permissions(1) || check_permissions(2) || check_permissions(7)) {
    		echo "loadForm('applicants.php')";
    	}
    ?>
</script>

</html>
