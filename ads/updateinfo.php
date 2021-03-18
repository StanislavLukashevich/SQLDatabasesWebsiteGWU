<?php

    session_start();
    $page_title = 'GWU Advising System';
    $error_msg = "";
 
     require_once('connectvars.php');
     require_once('appvars.php');
     require_once('header.php');
     require_once('navmenu.php');
  
     echo '<h4>Personal Information: </h4>';
     
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
          
  $sql = "UPDATE personal_info SET fname  = '$_POST[fname]', lname = '$_POST[lname]', dob = '$_POST[dob]', address = '$_POST[address]', email = '$_POST[email]' WHERE user_id  = $_POST[id]";
       
       if($dbc->query($sql) == TRUE)
       {
         header("refresh:1; url=changeinfo.php");
       }
       else
       {
         echo "No Update";
       }

    $dbc->close();


  require_once('footer.php');
?>
