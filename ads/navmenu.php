<?php
  // Generate the navigation menu
  echo '<hr />';
  if (isset($_SESSION['p_level'])) {
    //Set different buttons up for pages depending on
    echo '<a href="advising.php">Home</a> ';
    $admin  = "0";
    $graduatesecretary = "1";
    $chair = "2";
    $applicant = "3";
    $student = "4";
    $alumni = "5";
    $instructor = "6";
    $facultyreview = "7";
    $facultyadvisor = "8";
    require_once("utils.php");
    if(check_permissions(4)){
      echo '<a href="enrollment.php">View Enrollment</a> ';
      echo '<a href="form1.php">Form 1</a> ';
      echo '<a href="applygraduate.php">Apply to Graduate</a> ';
    }
    else if(check_permissions(5)){
      echo '<a href="enrollment.php">View Final Transcript</a> ';
    }
    else if(check_permissions(8)){
      echo '<a href="studentsel.php">Student Data</a> ';
    }
    else if(check_permissions(1)){
      echo '<a href="studentsel.php">Student Data</a> ';
    }
    else if(check_permissions(0)){
      echo '<a href="newuser.php">Create a New User</a> ';
      echo '<a href="studentsel.php">Student Data</a> ';
      echo '<a href="reset.php">Reset</a> ';
    }
    echo '<a href="changeinfo.php">Change Pers. Info</a> ';
   // echo '<a href="studentsel.php">Student Data</a> ';
    echo '<a href="logout.php">Log Out (' . $_SESSION['p_level'] . ')</a>';

  }
  else {
    echo '<a href="advising.php">Home</a> ';
    echo '<a href="login.php">Log In</a> ';
  }
  echo '<hr />';
?>
