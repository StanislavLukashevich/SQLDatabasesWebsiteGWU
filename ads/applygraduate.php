<?php
  session_start();
	$page_title = 'Advising System';

	//Load php tag into file once
  require_once('connectvars.php');
  //require_once('appvars.php');
  $_SESSION["navlink-prefix"] = "../php/";
  require_once('header.php');
  require_once('navmenu.php');
 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $uid = $_SESSION['id'];


  $queryA = "SELECT SUM(CASE grade WHEN 'A' THEN 1 ELSE 0 END) totalA FROM courses_taken WHERE student_id  = $uid;";
  $numberOfAs = mysqli_query($dbc, $queryA);
  $numberOfAs = $numberOfAs->fetch_assoc();
  $resultA= $numberOfAs['totalA'];

  $queryB = "SELECT SUM(CASE grade WHEN 'B' THEN 1 ELSE 0 END) totalB FROM courses_taken WHERE student_id = $uid;";
  $numberOfBs = mysqli_query($dbc, $queryB);
  $numberOfBs = $numberOfBs->fetch_assoc();
  $resultB= $numberOfBs['totalB'];

  $queryC = "SELECT SUM(CASE grade WHEN 'C' THEN 1 ELSE 0 END) totalC FROM courses_taken WHERE student_id = $uid;";
  $numberOfCs = mysqli_query($dbc, $queryC);
  $numberOfCs = $numberOfCs->fetch_assoc();
  $resultC= $numberOfCs['totalC'];

  $queryD = "SELECT SUM(CASE grade WHEN 'D' THEN 1 ELSE 0 END) totalD FROM courses_taken WHERE student_id = $uid;";
  $numberOfDs = mysqli_query($dbc, $queryD);
  $numberOfDs = $numberOfDs->fetch_assoc();
  $resultD= $numberOfDs['totalD'];

  $queryF = "SELECT SUM(CASE grade WHEN 'F' THEN 1 ELSE 0 END) totalF FROM courses_taken WHERE student_id = $uid;";
  $numberOfFs = mysqli_query($dbc, $queryF);
  $numberOfFs = $numberOfFs->fetch_assoc();
  $resultF= $numberOfFs['totalF'];

  $query2 = "SELECT SUM(catalog.credits) cHOURS FROM courses_taken, schedule, catalog WHERE courses_taken.student_id = $uid and catalog.c_id = schedule.course_id AND schedule.crn = courses_taken.crn;";
  $chours = mysqli_query($dbc, $query2);
  $chours = $chours->fetch_assoc();
  $totalhours= $chours['cHOURS'];

  $approvedreturn = "SELECT COUNT(universityid) approvedreturn FROM formone WHERE universityid = $uid AND department = 'APPROVED';";
  $formone = mysqli_query($dbc, $approvedreturn);
  $formone = $formone->fetch_assoc();
  $aprv= $formone['approvedreturn'];

         function avgGPAfunction($resultA, $resultB, $resultC, $resultD, $resultF, $totalhours)
         {
            $attemptedhours = ($resultA * 4.0 * 3) + ($resultB * 3.0 * 3) + ($resultC * 2.0 * 3) + ($resultD * 1.0 * 3) + ($resultF * 0.0 * 3);
            if($totalhours != 0)
            {
              $avggpa = $attemptedhours / $totalhours;
              return $avggpa;
            }
            else
            {
              return 0;
            }
         }
  $avggpa = avgGPAfunction($resultA, $resultB, $resultC, $resultD, $resultF, $totalhours);

         function numBadGrades($resultC, $resultD, $resultF)
         {
            $numBadGrades = $resultC + $resultD + $resultF;
            return $numBadGrades;
         }
   $numBadGrades = numBadGrades($resultC, $resultD, $resultF);


  $query3 = "SELECT SUM(catalog.credits) choursCSCI FROM courses_taken,catalog,schedule WHERE courses_taken.student_id = $uid AND catalog.c_no = 'CSCI' AND catalog.c_id = schedule.course_id AND schedule.crn = courses_taken.crn;";
  $choursCSCI = mysqli_query($dbc, $query3);
  $choursCSCI = $choursCSCI->fetch_assoc();
  $choursCSCItotal = $choursCSCI['choursCSCI'];

  $query4 = "SELECT program FROM student WHERE u_id = $uid;" ;
  $studenttype = mysqli_query($dbc, $query4);
  $studenttype = $studenttype->fetch_assoc();
  $program = $studenttype['program'];

?>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
    <div class="site-section">
    
    </div>
</body>


<?php
  if($program == 'MS' && $avggpa >= 3.0 && $chours >= 30 && $numBadGrades <= 2 && $aprv == 1)
  {
    $queryMS = "UPDATE student SET applied_to_grad = 2 WHERE u_id = $uid;";
    if(mysqli_query($dbc, $queryMS) == TRUE)
    {
      echo "<br>";
        echo '<p style="float: left; margin-left: 50px;"> </p>';
      echo "Request to the Graduate Secretary is sent to clear your for graduation. Stay tuned.";
      echo "<br>";
    }
  }
  else if($program == 'PhD' && $avggpa > 3.5 && $chours >= 36 && $numBadGrades <= 1 && $aprv == 1 && $choursCSCI >= 30 )
  {
    $queryPHD = "UPDATE student SET applied_to_grad = 1 WHERE u_id = $uid;";
    if(mysqli_query($dbc, $queryPHD) == TRUE)
    {
      echo "<br>";
        echo '<p style="float: left; margin-left: 50px;"> </p>';
      echo "Request to your Faculty Advisor is sent to approve your thesis. Stay tuned.";
      echo "<br>";
    }
  }
  else
  {
    echo "<br>";
      echo '<p style="float: left; margin-left: 50px;"> </p>';
    echo "You do not meet the requirements to graduate.";
    echo "<br>";
  }

    $queryGPA = "UPDATE student SET gpa = $avggpa WHERE u_id = $uid;";
    mysqli_query($dbc, $queryGPA);

  //require_once('footer.php');

?>
