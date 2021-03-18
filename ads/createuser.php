<?php

//NOTE: might need more work to input specific student data, ie their program/advisor ect.

    session_start();
    $page_title = 'GWU Advising System';
    $error_msg = "";

     require_once('connectvars.php');
     require_once('appvars.php');
     require_once('header.php');
     require_once('navmenu.php');

     echo '<h4>Create New User: </h4>';

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  //$sql = "UPDATE personalinfo SET ftname = '$_POST[fname]', ltname = '$_POST[lname]', dob = '$_POST[dob]', address = '$_POST[address]', cell = '$_POST[cell]' WHERE universid = $_POST[id]";
    $dbc->query('SET foreign_key_checks = 0');
    $sql = "INSERT INTO suser (utype, uemail, passwd) VALUES ( '$_POST[typeofuser]', '$_POST[email]', '$_POST[password]' );";
       if($dbc->query($sql) == TRUE)
       {
         header("refresh:1; url=newuser.php");
       }
       else
       {
         echo "Error: No Update";
       }

       //alumni
       //faculty
       //student

       $query = "select uid from suser where uemail = '$_POST[email]'";
       $result = mysqli_query($dbc, $query);
       $results = $result->fetch_assoc();
       $uid = $results["uid"];

    if($_POST['typeofuser'] == 'student'){
        $sql = "INSERT INTO student VALUES ('$uid', NULL, NULL, NULL, NULL, 0)";
        mysqli_query($dbc, $sql);
    }
    if($_POST['typeofuser'] == 'faculty'){
        $sql = "INSERT INTO faculty VALUES ('$uid')";
        mysqli_query($dbc, $sql);
    }
    if($_POST['typeofuser'] == 'alumni'){
        $sql = "INSERT INTO alumni VALUES ('$uid', NULL)";
        mysqli_query($dbc, $sql);
    }

    $dbc->query('SET foreign_key_checks = 1');

    $dbc->close();


  require_once('footer.php');
?>
