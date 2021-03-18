<?php


  session_start();
	$page_title = 'GWU Advising System Catalog';

	//Load php tag into file once
  require_once('connectvars.php');
  require_once('appvars.php');
	require_once('header.php');
  require_once('navmenu.php');


 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Grab the user-entered log-in data
  $query = "select crseid, title, semester, yeartaken, grade, chours from transcript, course where courseid = crseid and univerid = " . $_SESSION['uID'];

  $result= mysqli_query($dbc, $query);

  echo '<center><h3>Transcript</h3></center><div>';
  echo "<center><h4>University ID : ".$_SESSION['uID']."</h4></center>";
  if ($result->num_rows > 0)
    {
    // output data of each row
    echo '<table style="width:100%">';
    echo '<tr><th>Year</th><th>Semester</th><th>Course ID</th><th>Title</th><th>Grade</th><th>Credits</th></tr>';
    while($row = $result->fetch_assoc())
      {
        echo "<tr><td>" . $row["yeartaken"]. "</td><td>" . $row["semester"]. "</td><td>" . $row["crseid"]. "</td><td>" . $row["title"]. "</td><td>" . $row["grade"]. "</td><td>" . $row["chours"]. "</td></tr>";
      }
    echo '</table></div>';
    
    //IF USER IS AN ALUMNI, SHOW FINAL GPA
    if(strcmp($_SESSION['uType'], 'alumni') == 0){
      $query = "select gpa from student where unid = " . $_SESSION['uID'];
      $result = mysqli_query($dbc, $query);
      $row = $result->fetch_assoc();
      
      echo "<br><center><h4>Final GPA : ".$row["gpa"]."</h4></center>";
    }else{
      $uid = $_SESSION['uID'];
      $queryA = "SELECT SUM(CASE grade WHEN 'A' THEN 1 ELSE 0 END) totalA FROM transcript WHERE univerid = $uid;";
      $numberOfAs = mysqli_query($dbc, $queryA);
      $numberOfAs = $numberOfAs->fetch_assoc();
      $resultA= $numberOfAs['totalA'];
    
      $queryB = "SELECT SUM(CASE grade WHEN 'B' THEN 1 ELSE 0 END) totalB FROM transcript WHERE univerid = $uid;";
      $numberOfBs = mysqli_query($dbc, $queryB);
      $numberOfBs = $numberOfBs->fetch_assoc();
      $resultB= $numberOfBs['totalB'];
    
      $queryC = "SELECT SUM(CASE grade WHEN 'C' THEN 1 ELSE 0 END) totalC FROM transcript WHERE univerid = $uid;";
      $numberOfCs = mysqli_query($dbc, $queryC);
      $numberOfCs = $numberOfCs->fetch_assoc();
      $resultC= $numberOfCs['totalC'];
    
      $queryD = "SELECT SUM(CASE grade WHEN 'D' THEN 1 ELSE 0 END) totalD FROM transcript WHERE univerid = $uid;";
      $numberOfDs = mysqli_query($dbc, $queryD);
      $numberOfDs = $numberOfDs->fetch_assoc();
      $resultD= $numberOfDs['totalD'];
    
      $queryF = "SELECT SUM(CASE grade WHEN 'F' THEN 1 ELSE 0 END) totalF FROM transcript WHERE univerid = $uid;";
      $numberOfFs = mysqli_query($dbc, $queryF);
      $numberOfFs = $numberOfFs->fetch_assoc();
      $resultF= $numberOfFs['totalF'];
      
      $query2 = "SELECT SUM(chours) cHOURS FROM transcript WHERE univerid = $uid;";
      $chours = mysqli_query($dbc, $query2);
      $chours = $chours->fetch_assoc();
      $totalhours= $chours['cHOURS'] + 0.00;
      
      function avgGPAfunction($resultA, $resultB, $resultC, $resultD, $resultF, $totalhours){
            $attemptedhours = ($resultA * 4.00 * 3.00) + ($resultB * 3.00 * 3.00) + ($resultC * 2.00 * 3.00) + ($resultD * 1.00 * 3.00) + ($resultF * 0.00 * 3.00);
            $avggpa = $attemptedhours / $totalhours;
            return $avggpa;
      }
      $avggpa = avgGPAfunction($resultA, $resultB, $resultC, $resultD, $resultF, $totalhours);
      echo "<br><center><h4>Final GPA : ".$avggpa."</h4></center>";
    }
  }
  else
  {
    echo "<center>No Results Found</center";
  }
  $dbc->close();

  require_once('footer.php');
?>
