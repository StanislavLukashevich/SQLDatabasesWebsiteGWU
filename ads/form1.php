<!DOCTYPE html>
<html>

<head>
</head>

	<body>
    <?php

    session_start();

    require_once('connectvars.php');
	  require_once('appvars.php');
   $_SESSION["navlink-prefix"] = "../php/";
		require_once('header.php');
   
   ?>

        
    
<?php
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($dbc->connect_error)
    {
      die("Connection failed: " . $dbc->connect_error);
    }
    $dbc->query('SET foreign_key_checks = 0');
    $uid = $_SESSION['id'];

    $query = "SELECT * from formone where universityid = $uid";
    $result = mysqli_query($dbc, $query);

    if(mysqli_num_rows($result) > 0){
      echo '<script type="text/javascript">',
     'window.alert("Form1 has already been submitted");',
     '</script>';
     header("refresh:1; url=http://gwupyterhub.seas.gwu.edu/~sp20DBp2-ginerale/ginerale/php/home.php");
    }

		$page_title = 'GWU Advising System';
		//Load php tag into file once
	  //require_once('navmenu.php');

    ?>

    <script type="text/javascript">
      function chkcontrol(j)
      {
        var total=0;
        for(var i=0; i < document.form1.course.length; i++)
        {
          if(document.form1.course[i].checked)
          {
            total = total + 1;
          }
          if(total > 12)
          {
            alert("Minimum number of selected classes must be 10. Maximum number of selected classes must be 12.")
                document.form1.course[j].checked = false ;
            return false;
          }
        }
      }
      </script>
      <script type="text/javascript">
      function chkcontroll()
      {
        var tot=0;
        for(var i=0; i < document.form1.course.length; i++)
        {
          if(document.form1.course[i].checked)
          {
            tot = tot + 1;
          }
        }
          if(tot < 10)
          {
            alert("Minimum number of selected classes must be 10. Maximum number of selected classes must be 12.") ;
            return false;
          }
          if(tot > 12)
          {
            alert("Minimum number of selected classes must be 10. Maximum number of selected classes must be 12.") ;
            return false;
          }
      }
      </script>
      <script type="text/javascript">
      function populateCookies()
      {
        var expires;
        var date = new Date();
        date.setTime(date.getTime() + (10 * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();

        var tot=0;

        var array = [];

        var input = document.getElementsByTagName('input');
        document.getElementsByTagName('input')[1].checked = true;

        if(chkcontroll() != false){
          for(var i = 0; i < input.length; i++) {
            if(input[i].checked == true){
              document.cookie = input[i].value + "=" + "True" + expires + "; path=/";
            }else{
              document.cookie = input[i].value + "=" + "False" + expires + "; path=/";
            }
          }
        }else{
          for(var i = 0; i < input.length; i++) {
              document.cookie = input[i].value + "=" + "False" + expires + "; path=/";
          }
        }
      }
      </script>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <h1><p style="float: left; margin-left: 50px;">Form One</p> </h1>
      <br>
      <br>
    	<form name=form1 action = "<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <p style="float: left; margin-left: 50px;"> </p>
    		<input type="checkbox" id="6221" name="course" value="CSCI6221" onclick='chkcontrol(1)'>
    		<label for="6221">CSCI 6221 SW Paradigms</label><br>
        
        <p style="float: left; margin-left: 50px;"> </p>
    		<input type="checkbox" id="6461" name="course" value="CSCI6461" onclick='chkcontrol(2)'>
    		<label for="6461">CSCI 6461 Computer Architecture</label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6212" name="course" value="CSCI6212" onclick='chkcontrol(3)'>
    		<label for="6212">CSCI 6212 Algorithms </label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6220" name="course" value="CSCI6220" onclick='chkcontrol(4)'>
    		<label for="6220">CSCI 6220 Machine Learning </label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6232" name="course" value="CSCI6232" onclick='chkcontrol(5)'>
    		<label for="6232">CSCI 6232 Networks 1 </label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6233" name="course" value="CSCI6233" onclick='chkcontrol(6)'>
    		<label for="6233">CSCI 6233 Networks 2 </label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6241" name="course" value="CSCI6241" onclick='chkcontrol(7)'>
    		<label for="6241">CSCI 6241 Database 1 </label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6242" name="course" value="CSCI6242" onclick='chkcontrol(8)'>
    		<label for="6242">CSCI 6242 Database 2</label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6246" name="course" value="CSCI6246" onclick='chkcontrol(9)'>
    		<label for="6246">CSCI 6246 Compilers </label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6260" name="course" value="CSCI6260" onclick='chkcontrol(10)'>
    		<label for="6260">CSCI 6260 Multimedia </label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6251" name="course" value="CSCI6251" onclick='chkcontrol(11)'>
    		<label for="6251">CSCI 6251 Cloud Computing</label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6254" name="course" value="CSCI6254" onclick='chkcontrol(12)'>
    		<label for="6254">CSCI 6254 SW Engineering </label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6262" name="course" value="CSCI6262" onclick='chkcontrol(13)'>
    		<label for="6262">CSCI 6262 Graphics 1 </label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6283" name="course" value="CSCI6283" onclick='chkcontrol(14)'>
    		<label for="6283">CSCI 6283 Security 1 </label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6284" name="course" value="CSCI6284" onclick='chkcontrol(15)'>
    		<label for="6284">CSCI 6284 Cryptography</label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6286" name="course" value="CSCI6286" onclick='chkcontrol(16)'>
    		<label for="6286">CSCI 6286 Network Security</label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6325" name="course" value="CSCI6325" onclick='chkcontrol(17)'>
    		<label for="6325">CSCI 6325 Algorithms 2 </label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6339" name="course" value="CSCI6339" onclick='chkcontrol(18)'>
    		<label for="6339">CSCI 6339 Embedded Systems</label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6384" name="course" value="CSCI6384" onclick='chkcontrol(19)'>
    		<label for="6384">CSCI 6384 Cryptography 2 </label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6241" name="course" value="ECE6241" onclick='chkcontrol(20)'>
    		<label for="6241">ECE 6241 Communication Theory </label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6242" name="course" value="ECE6242" onclick='chkcontrol(21)'>
    		<label for="6242">ECE 6242 Information Theory</label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="checkbox" id="6210" name="course" value="MATH6210" onclick='chkcontrol(22)'>
    		<label for="6210">MATH 6210 Logic </label><br>

    		<p style="float: left; margin-left: 50px;"> </p>
        <input type="submit" value="Submit" name="submit" onclick='populateCookies();'>
        <br>

    	</form>

	<?php

    if(isset($_POST['submit']))
    {
      if($_COOKIE["CSCI6221"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6221)");
      }
      if($_COOKIE["CSCI6212"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6212)");
      }
      if($_COOKIE["CSCI6220"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6220)");
      }
      if($_COOKIE["CSCI6232"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6232)");
      }
      if($_COOKIE["CSCI6233"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6233)");
      }
      if($_COOKIE["CSCI6241"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6241)");
      }
      if($_COOKIE["CSCI6242"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6242)");
      }
      if($_COOKIE["CSCI6246"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6246)");
      }
      if($_COOKIE["CSCI6251"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6251)");
      }
      if($_COOKIE["CSCI6254"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6254)");
      }
      if($_COOKIE["CSCI6260"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6260)");
      }
      if($_COOKIE["CSCI6262"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6262)");
      }
      if($_COOKIE["CSCI6283"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6283)");
      }
      if($_COOKIE["CSCI6284"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6284)");
      }
      if($_COOKIE["CSCI6286"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6286)");
      }
      if($_COOKIE["CSCI6325"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6325)");
      }
      if($_COOKIE["CSCI6339"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6339)");
      }
      if($_COOKIE["CSCI6384"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6384)");
      }
      if($_COOKIE["CSCI6461"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'CSCI', 6461)");
      }
      if($_COOKIE["ECE6241"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'ECE', 6241)");
      }
      if($_COOKIE["ECE6242"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'ECE', 6242)");
      }
      if($_COOKIE["MATH6210"] == "True")
      {
        $dbc->query("INSERT INTO formone (universityid, department, cnumber) VALUES ($uid, 'MATH', 6210)");
      }
      echo '<script type="text/javascript">',
     'window.alert("Form1 successfully submitted");',
     '</script>';
    }

    $dbc->query('SET foreign_key_checks = 1');
    $dbc->close();

   require_once('footer.php');
  ?>

	</body>


</html>
