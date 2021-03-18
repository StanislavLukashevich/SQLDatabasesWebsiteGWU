<?php
  
  //Start session to gather variables, Print page title
  session_start();
	$page_title = 'Advising System';

	//Load php tag into file once
  require_once('connectvars.php');
  require_once('appvars.php');
	require_once('header.php');
  require_once('navmenu.php');
   
  //Load DBC
 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  
  ?>
  
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="100">
  <div class="site-section">
    <div class="row">
    <div class="col-xl-9 mx-auto">


  <?php
  //These are the checks we run at the start of the page. Depending on user status,
  //we can accept their form 1 data, accept their thesis, or graduate them and move them into alumni.
  if(isset($_POST["acceptform1"])){              
    //Accept user's form 1 data
    $query = "INSERT into formone (universityid, department, cnumber) VALUES ('$_POST[acceptform1]', 'APPROVED', 6666);";
    mysqli_query($dbc, $query);
    echo '<center><h3>Student Form Accepted</h3></center><hr />';
  }
  else if(isset($_POST["acceptthesis"])){
    //Update user's status to "waiting for acceptance of graduation"
    $query = "UPDATE student SET applied_to_grad=2 WHERE u_id = '$_POST[acceptthesis]'";
    mysqli_query($dbc, $query);
    echo '<center><h3>Student Thesis Accepted</h3></center><hr />';  
  }
  else if(isset($_POST["cleargrad"])){
    //Need to know the students program to insert a proper program into alumni table
    $programquery = "SELECT program FROM student WHERE u_id = '$_POST[cleargrad]';";
    $program1 = mysqli_query($dbc, $programquery);
    $program = $program1->fetch_assoc();
    $programstring = $program["program"];
    //Graduate User
    $query = "UPDATE student SET applied_to_grad=3 WHERE u_id = '$_POST[cleargrad]'";
    mysqli_query($dbc, $query);
    $query = "UPDATE users SET p_level ='5' WHERE id = '$_POST[cleargrad]'";
    mysqli_query($dbc, $query);
    
    //Move user into alumni
    $query = "INSERT INTO alumni (univid, yeargrad, program) VALUES ('$_POST[cleargrad]', 2020, '$programstring')";
    mysqli_query($dbc, $query);
    echo '<center><h3>Student Graduated</h3></center><hr />';  
  }
  else if(isset($_POST["Assign"])){
    //Update User's advisor ID
    $query = "UPDATE student SET advisorid = '$_POST[assignAdvi]' WHERE u_id = '$_POST[assignstuID]'";
    mysqli_query($dbc, $query);
    
    echo "<center><h3>Student Advisor updated to '$_POST[assignAdvi]'</h3></center><hr />";  
  }
  
  
  //SEARCH BAR (by university ID)
  echo '<p style="float: left; margin-left: 50px;"> </p>';
  echo '<form action="" method="post">';
  echo  '<label for="univID">Search Students By University ID:</label><br>';
  echo '<p style="float: left; margin-left: 50px;"> </p>';
  echo  '<input type="text" id="univID" name="univID"><br>';
  echo '<p style="float: left; margin-left: 50px;"> </p>';
  echo  '<input type="submit" name="Search" value="Search">';
  echo	'</form>';
  echo '<hr />';
  
  //IF A USER HAS BEEN SEARCHED
  if(isset($_POST["Search"])){
  
    //THIS ONLY ALLOWS FOR AN ADVISOR TO LOOK UP THEIR STUDENTS AND ONLY THEIR STUDENTS
    if(strcmp($_SESSION['p_level'], strval(8)) == 0)
    {
      echo '<center><h4>Student Found</h4></center><div class="advbasicdata">';  
      $input = $_POST['univID'];
      
      
      //LOADING SEARCHED STUDENT BASIC DATA INTO A TABLE
      $query = "select * from student, personal_info WHERE student.u_id = '$input' and student.advisorid = '$_SESSION[id]'
      and student.u_id = personal_info.user_id "; 
      $result = mysqli_query($dbc, $query);
      if(mysqli_num_rows($result) > 0){
        echo '<table style="width:100%">';
        echo '<tr><th>University ID</th><th>First Name</th><th>Last Name</th><th>Advisor ID</th><th>GPA</th><th>Program</th><th>Applied to Grad?</th></tr>';
        while($row = $result->fetch_assoc()){
          echo "<td>" . $row["u_id"]. "</td><td>" . $row["fname"]. "</td><td>" . $row["lname"]. "</td><td>" . $row["advisorid"]. "</td><td>" . $row["gpa"]. "</td><td>" . $row["program"]. "</td>";
          $stuID = $row["u_id"];
          if($row["applied_to_grad"] == 0 || $row["applied_to_grad"] == NULL){
            echo "<td>No</td></tr>";
          }
          else{
            echo "<td>Yes</td></tr>";
          }
        }
        echo '</table></div>';
        echo '<hr />';
        
        
        //SHOW STUDENT'S TRANSCRIPT (ONLY IF BASIC DATA APPEARS)
        $query = "select c.department , c.c_no , s.semester, s.year, ct.grade, c.credits from catalog as c, courses_taken as ct, schedule as s where c.c_id = s.course_id and ct.crn = s.crn and ct.student_id  = '$_POST[univID]'";       
        $result = mysqli_query($dbc, $query);
        echo '<center><h4>Transcript</h4></center><div class="transcript">';
        if ($result->num_rows > 0)
        {
          echo '<table style="width:100%">';
          echo '<tr><th>Year</th><th>Semester</th><th>Course ID</th><th>Title</th><th>Grade</th><th>Credits</th></tr>';
          while($row = $result->fetch_assoc())
          {
              echo "<tr><td>" . $row["year"]. "</td><td>" . $row["semester"]. "</td><td>" . $row["department"]. "</td><td>" . $row["c_no"]. "</td><td>" . $row["grade"]. "</td><td>" . $row["credits"]. "</td><td>";
          }
          echo '</table></div>';
          echo '<hr />';
		}
          
          
          //SHOW STUDENT FORMONE DATA (ONLY IF TRANSCRIPT APPEARS)
          $query = "select f.department, f.cnumber, c.credits  from formone as f, catalog as c where f.universityid = '$_POST[univID]' and f.cnumber = c.c_no ";
          $result = mysqli_query($dbc, $query);
    
          echo '<center><h4>Form One Data</h4></center><div class="formdata">';
          if ($result->num_rows > 0)
          {
            echo '<table style="width:100%">';
            echo '<tr><th>Course ID</th><th>Title</th><th>Credits</th></tr>';
            while($row = $result->fetch_assoc())
            {
                echo "<tr><td>" . $row["department"]. "</td><td>" . $row["cnumber"]. "</td><td>"  . $row["credits"]. "</td><td>";
            }
            echo '</table></div>';
            
            
            //CHECK TO SEE IF STUDENT'S FORM 1 HAS BEEN APPROVED
            $query = "select * from formone where universityid = '$_POST[univID]' and department = 'APPROVED'";
            $result = mysqli_query($dbc, $query);
            if ($result->num_rows <= 0){            
              //IF IT HAS NOT BEEN APPROVED, GIVE A BUTTON TO APPROVE IT
              echo  '<form action="" method="post">';
              echo  '<button type="submit" name="acceptform1" value="'.$_POST["univID"].'">Accept Form 1</button>';
              echo	'</form>';                    
            }
            $query = "select program, applied_to_grad from student where u_id = '$_POST[univID]'";
            $result = mysqli_query($dbc, $query); 
            if($result->num_rows > 0){
              //IF IT HAS BEEN APPROVED, CHECK TO SEE IF USER IS A PHD STUDENT AND NEEDS THEIR THESIS APPROVED
              $row = $result->fetch_assoc();
              if(strcmp($row["program"], 'PhD') == 0 && $row["applied_to_grad"] == 1){
                echo  '<form action="" method="post">';
                echo  '<button type="submit" name="acceptthesis" value="'.$_POST["univID"].'">Accept Thesis</button>';
                echo	'</form>';   
                
              }        
          }else{
            echo "<center>No Form Data Found</center>";
          }        
        }else{
          echo "<center>No Results Found</center>";
        }        
      }else{
        echo '<center>Student Not Found</center>';
      }  
      
      
    // THIS IS FOR GS AND ADMIN : ALLOWS THEM TO VIEW EVERY USER AND THEIR ADVISOR ID'S. CANNOT CLEAR A USER'S THESIS.        
    }else{
      //ALLOW GS/ADMIN TO ASSIGN THE STUDENT'S ADVISOR
      echo '<br><form action="" method="post">';
      echo '<p style="float: left; margin-left: 50px;"> </p>';
      echo  '<label for="assignAdvi">Assign Student an Advisor</label><br>';
      echo '<p style="float: left; margin-left: 50px;"> </p>';
      echo  '<input type="text" id="assignAdvi" name="assignAdvi"><br>';
      echo '<p style="float: left; margin-left: 50px;"> </p>';
      echo  '<input type="hidden" id="assignstuID" name="assignstuID" value ="'.$_POST['univID'].'">';
      echo  '<input type="submit" name="Assign" value="Assign">';
      echo	'</form><br>';
  
      echo '<center><h4>Student Found</h4></center><div class="basicdata">';  
      $input = $_POST['univID'];
      
      //LOADING BASIC STUDENT DATA
      $query = "select * from student, personal_info WHERE student.u_id = '$input'  and student.u_id = personal_info.user_id ";  
      $result = mysqli_query($dbc, $query);
      if(mysqli_num_rows($result) > 0){
        echo '<table style="width:100%">';
        echo '<tr><th>University ID</th><th>First Name</th><th>Last Name</th><th>Advisor ID</th><th>GPA</th><th>Program</th><th>Applied to Grad?</th></tr>';
        while($row = $result->fetch_assoc()){
          echo "<td>" . $row["u_id"]. "</td><td>" . $row["fname"]. "</td><td>" . $row["lname"]. "</td><td>" . $row["advisorid"]. "</td><td>" . $row["gpa"]. "</td><td>" . $row["program"]. "</td>";
          if($row["applied_to_grad"] == 0){
            echo "<td>No</td></tr>";
          }
          else{
            echo "<td>Yes</td></tr>";
          }
        }
        echo '</table></div>';
        echo '<hr />';
        
        
        //SHOW STUDENT'S TRANSCRIPT (ONLY IF BASIC DATA APPEARS)
        $query = "select c.department , c.c_no , s.semester, s.year, ct.grade from catalog as c, courses_taken as ct, schedule as s where c.c_id = s.course_id and ct.crn = s.crn and ct.student_id  = '$_POST[univID]'";       
        $result = mysqli_query($dbc, $query);
        echo '<center><h4>Transcript</h4></center><div class="transcript">';
        if ($result->num_rows > 0){
          echo '<table style="width:100%">';
          echo '<tr><th>Year</th><th>Semester</th><th>Course ID</th><th>Title</th><th>Grade</th><th>Credits</th></tr>';
          while($row = $result->fetch_assoc()){
              echo "<tr><td>" . $row["year"]. "</td><td>" . $row["semester"]. "</td><td>" . $row["department"]. "</td><td>" . $row["c_no"]. "</td><td>" . $row["grade"]. "</td><td>";
          }
          echo '</table></div>';
          echo '<hr />';
          
          
          //SHOW STUDENT FORMONE DATA (ONLY IF TRANSCRIPT APPEARS)
          $query = "select f.department, f.cnumber, c.credits  from formone as f, catalog as c where f.universityid = '$_POST[univID]' and c.c_no   = f.cnumber";
          $result = mysqli_query($dbc, $query);
          echo '<center><h4>Form One Data</h4></center><div class="formdata">';
          if ($result->num_rows > 0)
          {
            echo '<table style="width:100%">';
            echo '<tr><th>Course ID</th><th>Title</th><th>Credits</th></tr>';
            while($row = $result->fetch_assoc()){
                echo "<tr><td>" . $row["cnumber"]. "</td><td>" . $row["department"]. "</td><td>" . $row["credits"]. "</td></tr>";
            }
            echo '</table></div>';
            
            
            //CHECK TO SEE IF STUDENT'S FORM 1 HAS BEEN APPROVED
            $query = "select * from formone where universityid = '$_POST[univID]' and department = 'APPROVED'";
            $result = mysqli_query($dbc, $query);
            if ($result->num_rows <= 0)
            {
              //IF IT HAS NOT BEEN APPROVED, GIVE A BUTTON TO APPROVE IT
              echo  '<form action="" method="post">';
              echo  '<button type="submit" name="acceptform1" value="'.$_POST["univID"].'">Accept Form 1</button>';
              echo	'</form>';                   
            }
            $query = "select program, applied_to_grad from student where u_id = '$_POST[univID]'";
            $result = mysqli_query($dbc, $query); 
            if($result->num_rows > 0)
            {
              //IF IT HAS BEEN APPROVED, CHECK TO SEE IF USER IS A PHD STUDENT AND NEEDS THEIR THESIS APPROVED
              $row = $result->fetch_assoc();
              if( ( strcmp($row["program"], 'MS') == 0 && $row["applied_to_grad"] == 2) || (strcmp($row["program"], 'PhD') == 0 && $row["applied_to_grad"] == 2) )
              {
                  //IF THEY ARE, GIVE A BUTTON FOR ADVISOR TO GRADUATE THEM
                echo  '<form action="" method="post">';
                echo  '<button type="submit" name="cleargrad" value="'.$_POST["univID"].'">Clear For Graduation</button>';
                echo	'</form>';   
              }           
            }
          }else{
            echo "<center>No Form Data Found</center>";
          }        
        }else{
          echo "<center>No Results Found</center>";
        }        
      }else{
        echo '<center>Student Not Found</center>';
      }    
    }
  }
  
  
  
  
  
  //SHOW ALL STUDENTS : THIS IS ONLY SHOWN IF A STUDENT HAS NOT YET BEEN SEARCHED
  else{  
    //DISPLAY ALL USERS FOR GS AND ADMIN
    if((strcmp($_SESSION['p_level'], strval(2)) == 0 || (strcmp($_SESSION['p_level'], strval(0))) == 0)){
      echo '<center><h4>Student Selection</h4></center><div class="stuData">';
   	  $query = "select * from student, personalinfo where u_id = unid and (NOT applied_to_grad = 3)";
      $result= mysqli_query($dbc, $query);
      
      
      //PRINT OUT ALL USERS TO A TABLE
      if ($result->num_rows > 0){
        echo '<table style="width:100%">';
        echo '<tr><th>First Name</th><th>Last Name</th><th>University ID</th><th>Advisor ID</th><th>Program</th></tr>'; 
        while($row = $result->fetch_assoc()){
          echo "<tr><td>" . $row["ftname"]. "</td><td>" . $row["ltname"]. "</td><td>" . $row["unid"]. "</td><td>" . $row["advisorid"]. "</td><td>" . $row["program"]. "</td></tr>";
        }
        echo '</table></div><br>';
      }
      else{
        echo "0 results";
      }     
    }
    
    
    //DISPLAY ONLY USERS FOR THE SELECTED ADVISOR
    else if(strcmp($_SESSION['p_level'], strval(8)) == 0)
    {
      //$input = $_POST['univID'];
      echo '<center><h4>Student Selection</h4></center><div class="advstuData">';
   	  $query = "select pi.fname, pi.lname, s.u_id, s.program from student as s, personal_info as pi where s.advisorid = '$_SESSION[id]' and pi.user_id = s.u_id "; //and (NOT applied_to_grad = 3)
      $result= mysqli_query($dbc, $query);
      
      //PRINT OUT USERS TO A TABLE
      if ($result->num_rows > 0){
        echo '<table style="width:100%">';
        echo '<tr><th>First Name</th><th>Last Name</th><th>University ID</th><th>Program</th></tr>';
        while($row = $result->fetch_assoc()){
          echo "<tr><td>" . $row["fname"]. "</td><td>" . $row["lname"]. "</td><td>" . $row["u_id"]. "</td><td>" . $row["program"]. "</td></tr>";
        }
        echo '</table></div><br>';
      }
      else{
        echo "0 results";
      }    
      
    }
  }
  
  
  
  //THIS ONLY ALLOWS FOR A GS TO LOOK UP ALUMNI BY YEAR
  if(strcmp($_SESSION['p_level'], strval(1)) == 0)
  {
    //SEARCH BAR (alumnis by graduation year)
  echo '<form action="" method="post">';
    echo '<p style="float: left; margin-left: 50px;"> </p>';
  echo  '<label for="alumniYear">Search Alumni By Graduation Year:</label><br>';
    echo '<p style="float: left; margin-left: 50px;"> </p>';
  echo  '<input type="text" id="alumniYear" name="alumniYear"><br>';
    echo '<p style="float: left; margin-left: 50px;"> </p>';
  echo  '<input type="submit" name="AlumniSearch" value="AlumniSearch">';
  echo	'</form>';
  echo '<hr />';
  
  //IF THE SEARCH WAS PERFORMED
  if(isset($_POST["AlumniSearch"]))
  {
      $input = $_POST['alumniYear'];
      
      //LOADING SEARCHED STUDENT BASIC DATA INTO A TABLE
      $query = "select a.yeargrad, a.program, pi.fname, pi.lname, pi.email from personal_info as pi, alumni as a WHERE yeargrad = '$input' and a.univid = pi.user_id;"; 
      $result = mysqli_query($dbc, $query);
      if(mysqli_num_rows($result) > 0)
      {
        echo '<center><h4>Alumni Found</h4></center><div class="advbasicdata">'; 
        echo '<table style="width:100%">';
        echo '<tr><th>Graduation Year</th><th>Program</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>';
        while($row = $result->fetch_assoc())
        {
          echo "<td>" . $row["yeargrad"]. "</td><td>" . $row["program"]. "</td><td>"  . $row["fname"]. "</td><td>" . $row["lname"]. "</td><td>" . $row["email"]. "</td>";
        }
        echo '</table></div>';
        echo '<hr />';
      }
      
      //IF NOTHING ENTERED - DISPLAY ALL ALUMNAE
      else if( $_POST['alumniYear'] == NULL )
      {
      $query = "select a.yeargrad, a.program, pi.fname, pi.lname, pi.email from personal_info as pi, alumni as a WHERE a.univid = pi.user_id;"; 
      $result = mysqli_query($dbc, $query);
      if(mysqli_num_rows($result) > 0)
      {
        echo '<center><h4>Alumni Found</h4></center><div class="advbasicdata">'; 
        echo '<table style="width:100%">';
        echo '<tr><th>Graduation Year</th><th>Program</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>';
        while($row = $result->fetch_assoc())
        {
          echo "<tr><td>" . $row["yeargrad"]. "</td><td>" . $row["program"]. "</td><td>"  . $row["fname"]. "</td><td>" . $row["lname"]. "</td><td>" . $row["email"]. "</td><td>";
        }
        echo '</table></div>';
        echo '<hr />';
        echo '<br>';
      }
      else
      {
        echo '<center><h4>No Alumnae Found</h4></center><div class="advbasicdata">'; 
      }
      }
      else
      {
        echo '<center><h4>No Alumnae Found</h4></center><div class="advbasicdata">'; 
      }
      
    }
   }
  
  
  $dbc->close();
  //require_once('footer.php');
?>
    </div>
    </div>
    </div>
</body>
  
