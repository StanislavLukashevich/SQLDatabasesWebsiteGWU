<?php
  require_once('../apps/includes/utils.php');

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // create a new ID
      $id = str_pad(mt_rand(1,99999999), 8, '0', STR_PAD_LEFT);

      $pword = htmlspecialchars($_POST["password"]);

      $query = "INSERT INTO users (id, p_level, password) VALUES ('$id', '3', '$pword')";
      try_insert($dbc, $query, NULL);

      $query = "INSERT INTO personal_info (user_id, fname, lname, email) VALUES ($id, '$_POST[fname]', '$_POST[lname]', '$_POST[email]')";
      try_insert($dbc, $query, NULL);

      $response = array();
      $response["id"] = $id;
      $response["pword"] = $pword;
      echo json_encode($response);
  }
?>
