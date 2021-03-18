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
 	$query = "select * from course";     
       
       
  $result= mysqli_query($dbc, $query);

  echo '<center><h4>Course Catalogue</h4></center><div>';
    

  if ($result->num_rows > 0)
    {
    // output data of each row
    echo '<table style="width:100%">';
    echo '<tr><th>Course ID</th><th>Title</th><th>Credits</th><th>Prerequisites</th></tr>';
    while($row = $result->fetch_assoc()) 
      {
        echo "<td>" . $row["courseid"]. "</td><td>" . $row["title"]. "</td><td>" . $row["credits"]. "</td>";
        if(isset($row["prereqone"])){
          echo "<td>". $row["prereqone"];
          if(isset($row["prereqtwo"])){
            echo ", ". $row["prereqtwo"];
          }
        }else{
          echo "<td>";
        }
        echo '</td></tr>';
      }
      echo '</table></div>';
  } 
  else 
  {
    echo "0 results";
  }
  $dbc->close();
    
  require_once('footer.php');
?>