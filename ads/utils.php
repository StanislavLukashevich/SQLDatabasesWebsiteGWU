<?php
	// For random utility functions that should be available for access in all files  - can just include this file in the header
    require_once('connectvars.php');
 

	if (!isset($_SESSION)) {
		session_start();
	}
 
    function check_permissions($role) {
      // is this role in the p_level?
      return(strpos($_SESSION['p_level'], strval($role)) !== false || $_SESSION['p_level'] == strval($role));
    }
    
?>