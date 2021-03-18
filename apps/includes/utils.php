<?php
	// For random utility functions that should be available for access in all files  - can just include this file in the header
  if (file_exists('../../php/connectvars.php')) {
    require_once('../../php/connectvars.php');
  } else {
    require_once('../php/connectvars.php');
  }

	if (!isset($_SESSION)) {
		session_start();
	}

	function make_url($file, $query) {
      return 'http://' . $_SERVER["HTTP_HOST"] . make_rel_url($file, $query);
    }
    function make_rel_url($file, $query) {
      return url($file) . '?' . http_build_query($query);
    }
    function get_path_file() {
    	$path = explode('/', $_SERVER["SCRIPT_NAME"]); 
    	return $path[count($path) - 1];
    }
    function url($file) {
      return dirname($_SERVER["PHP_SELF"]) . '/' . $file;
    }
    function try_insert($dbc, $query, $success) {
      if (mysqli_query($dbc, $query)) {
        if (!is_null($success)) echo "Success: " . $success . '<br>\n';
        return $dbc->insert_id;
      }
      else throw new Exception('Error with query ' . $query . ': ' . mysqli_error($dbc));
    }
    function try_query($dbc, $query, $success) {
      if ($result = mysqli_query($dbc, $query)) {
        if (!is_null($success)) echo "Success: " . $success . '<br>\n';
        return $result;
      }
      else throw new Exception('Error with query ' . $query . ': ' . mysqli_error($dbc));
      return null;
    }

    function check_permissions($role) {
      // is this role in the p_level?
      return(strpos($_SESSION["p_level"], strval($role)) !== false || $_SESSION["p_level"] == strval($role));
    }

    function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    function alpha($string) {
      return preg_match("/^[a-zA-Z0-9\s]*$/", $string);
    }

?>
