<!DOCTYPE html>
<html lang="en">

<head>

	<title> Grades - Ginerale</title>

  <style>
    .dropbtn:hover, .dropbtn:focus {
      background-color: #3e8e41;
    }

    #myInput {
      box-sizing: border-box;
      background-image: url('searchicon.png');
      background-position: 14px 12px;
      background-repeat: no-repeat;
      font-size: 16px;
      padding: 14px 20px 12px 45px;
      border: none;
      border-bottom: 1px solid #ddd;
    }

    #myInput:focus {outline: 3px solid #ddd;}

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f6f6f6;
      min-width: 230px;
      overflow: auto;
      border: 1px solid #ddd;
      z-index: 1;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown a:hover {background-color: #ddd;}

    .show {display: block;}
  </style>

	<?php
		require_once ('header.php'); 
		session_start();
	
		$id = $_SESSION['id'];

		if (empty ($id)) {
			header ('Location: home.php');
		}

		$plevel = $_SESSION['p_level'];

		if (strcmp ($plevel, "4") == 0) {
			header ('Location: home.php');
		}

		include ('connectvars.php');    
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

		// Find all classes 
		$c_query = "SELECT department, c_no, title, c_id FROM catalog";

		// Find all semesters
		$s_query = 'SELECT semester, year 
				  FROM catalog, schedule
				  WHERE schedule.course_id=catalog.c_id';

		// If this is an instructor, query is more specific
		if (strpos ($plevel, "6") !== false) {
			// Find all classes 
			$c_query = "SELECT department, c_no, title, c_id
						FROM catalog, schedule, courses_taught
						WHERE c_id=course_id and schedule.crn=courses_taught.crn
							and f_id=". $_SESSION['id'] ."
						GROUP BY department, c_no, title, c_id";

			// Find all semesters this instructor is teaching
			$s_query = "SELECT semester, year 
					  FROM catalog, schedule, courses_taught
					  WHERE schedule.course_id=catalog.c_id
						and f_id=". $_SESSION['id'] ."
					  GROUP BY semester, year 
					  ORDER BY semester DESC, year ASC";
		} else { // General query for all classes
			// Find all classes 
			$c_query = "SELECT department, c_no, title, c_id FROM catalog";

			// Find all semesters
			$s_query = "SELECT semester, year 
					  FROM catalog, schedule
					  WHERE schedule.course_id=catalog.c_id
					  GROUP BY semester, year 
					  ORDER BY semester DESC, year ASC";
		}

		$classes = mysqli_query ($dbc, $c_query);
		$semesters = mysqli_query ($dbc, $s_query);
    ?>

</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

    <div class="container mt-5 pt-3">
		<div class="row">
			<h2 class="section-title-underline mb-4">
				<span>Change Grades</span>
			</h2>
		</div>

		<div class="row">
			<h4 class="pl-1 font-weight-lighter"><small> 
				Use the dropdown menus to select a specific class and semester.
			</small></h4>  
		</div>	

	<!-- Class select -->
		<div class="row mt-1 pt-2">

		<div class="col-sm">
			<div class="dropdown">
				<button onclick="myFunction()" class="btn-primary">
					Select Class
				</button>
				<div id="myDropdown" class="dropdown-content">
					<input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
    <?php
		// Need to add all classes to dropdown menu
		while ($c = mysqli_fetch_array ($classes)) {
			$course = '<b>'. $c['department'] . " " . $c['c_no'] . "</b>: " . $c['title'];

			if (isset ($_GET['semester'])) {
				echo '<a href="grades.php?cid='. $c['c_id'] .'&semester='. $_GET['semester'] .'">'. $course .'</a>';
			} else {
				echo '<a href="grades.php?cid='. $c['c_id'] .'">'. $course .'</a>';
			}
		} 
	?>
				</div>
			</div>
	
	<!-- Semester select -->
			<div class="dropdown">
				<button onclick="myFunction2()" class="btn-primary">
					Select Semester
				</button>
				<div id="sem_dropdown" class="dropdown-content">
					<input type="text" placeholder="Search.." id="sem_search" onkeyup="filterFunction2()">
    <?php
		// Need to add all semesters to dropdown
		
		while ($c = mysqli_fetch_array ($semesters)) {
			$sem = '<b>'. $c['semester'] . " " . $c['year'];

			if (isset ($_GET['cid'])) {
				echo '<a href="grades.php?cid='. $_GET['cid'] .'&semester='. $c['semester'] . $c['year'] .'">'. $sem .'</a>';
			} else {
				echo '<a href="grades.php?semester='. $c['semester'] . $c['year'] .'">'. $sem .'</a>';
			}
			
		} 
	?>
				</div>
			</div>
		</div>
		</div>

		<div class="row">

	<?php
		// If both are set, show grades for the class
		if (isset ($_GET['cid']) && isset ($_GET['semester'])) {
			require_once ('enrollment.php');
		}
		else if (isset ($_GET['cid'])) {
			$query = "SELECT department, c_no, title
					  FROM catalog
					  WHERE c_id='". $_GET['cid'] ."'";
			$c = mysqli_fetch_array (mysqli_query ($dbc, $query));
			$class = $c['department'] . " " . $c['c_no'] . ": " . $c['title'];
			echo "<div class='alert alert-success' role='alert'>
					<b> Selected: </b> $class
				  </div>
				 ";
		} else if (isset ($_GET['semester'])) {
			echo "<div class='alert alert-success' role='alert'>
					Selected: ". $_GET['semester'] ."
				  </div>
				 ";
		}
	?> 

		</div>
	</div>

<script>
      /* When the user clicks on the button,
      toggle between hiding and showing the dropdown content */
      function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
      }

      function filterFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("myDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
          txtValue = a[i].textContent || a[i].innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
          } else {
            a[i].style.display = "none";
          }
        }
      }

	  function myFunction2() {
        document.getElementById("sem_dropdown").classList.toggle("show");
      }

      function filterFunction2() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("sem_search");
        filter = input.value.toUpperCase();
        div = document.getElementById("sem_dropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
          txtValue = a[i].textContent || a[i].innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
          } else {
            a[i].style.display = "none";
          }
        }
      }
</script>

</body>
</html>
