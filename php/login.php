<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700,900" rel="stylesheet">
  <link rel="stylesheet" href="../fonts/icomoon/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
  <link rel="stylesheet" href="../css/owl.carousel.min.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="../css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="../css/aos.css">
  <link href="../css/jquery.mb.YTPlayer.min.css" media="all" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="../css/style.css">
</head>
  
<?php
  require_once('connectvars.php');
  // TODO: Start the session
  session_start();
  // Clear the error message
  $error_msg = "";
  // TODO: If the user isn't logged in, try to log them in
  if (!empty($_POST)) {
    if (isset($_POST['submit'])) {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      // Grab the user-entered log-in data
      $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));
      if (!empty($user_username) && !empty($user_password)) {
        // TODO: Look up the username and password in the database
        $query = "SELECT * FROM users WHERE id = '$user_username' and password = '$user_password'";
        $data = mysqli_query($dbc, $query);
        // If The log-in is OK
        if (mysqli_num_rows($data) == 1) {
          $row = mysqli_fetch_array($data);
          //TODO: so set the user ID and username session vars
          $_SESSION['id'] = $row['id'];
          $_SESSION['password'] = $row['password'];
          $_SESSION['p_level'] = $row['p_level'];
          $_SESSION['id1'] = $_SESSION['p_level1'] = "";
          //TODO: redirect to index.php
          if($row['id'] == $row['password']){
            $home_url = "set_info.php";
            header('Location: ' . $home_url);
          }else{
            $home_url = "home.php";
            header('Location: ' . $home_url);
          }
        }
        else {
          // The username/password are incorrect so set an error message
          $error_msg = 'Sorry, you must enter a valid user id and password to log in.';
        }
      }
      else {
        // The username/password weren't entered so set an error message
        $error_msg = 'Sorry, you must enter your user id and password to log in.';
      }
    }
  }
?>

<body>
  <!-- Navigation -->
  <!-- Page Content -->
  <div class="site-section">
  <div class="container">

  <div class="row justify-content-center text-center">
        <img src="../images/icon.png" alt="">
        <!-- <p style="color: #00158B;" >Farm Fresh</p> -->
  </div>

  <div class="row justify-content-center">
      <div class="col-md-5">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="loginForm">
          <div class="row">
            <div class="col-md-12 form-group">
              <label for="username">ID: </label>
              <input type="text" id="username" name="username" class="form-control form-control-lg">
            </div>
            <div class="col-md-12 form-group">
              <label for="password">Password: </label>
              <input type="password" id="password" name="password" class="form-control form-control-lg">
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <input type="submit" value="Log In" class="btn btn-primary btn-lg px-5" name="submit">
              <button type="button" name="trigger" onclick='toggleRegister()' class="btn btn-secondary btn-lg px-5" href='add_user.php'>Apply</button>
<?php
  if (empty($_SESSION['id'])) {
    echo '<br><br><p class="text-danger">' . $error_msg . '</p>';
  }
?>
              </div>
            </div>
        </form>
        <form id="registerForm">
          <p>Register as an applicant and start your application!</p>
          <div class="row">
            <div class="col-md-6 form-group">
                  <label for="fname">First Name</label>
                  <?php echo '<input type="text" maxlength=20 id="fname" name="fname" class="form-control form-control-lg text-muted" value="">';?>
            </div>
            <div class="col-md-6 form-group">
                <label for="lname">Last Name</label>
                <?php echo '<input type="text" maxlength=20 id="lname" name="lname" class="form-control form-control-lg text-muted" value="">';?>
            </div>
          </div>
          <div class="row">
              <div class="col-md-12 form-group">
                  <label for="email">Email Address</label>
                  <?php echo '<input type="text" maxlength=30 id="email" name="email" class="form-control form-control-lg text-muted" value="">';?>
              </div>
          </div>
          <div class="row">
              <div class="col-md-12 form-group">
                <label for="pword">Password: </label>
                <input type="password" id="pword" name="password" class="form-control form-control-lg">
              </div>
          </div>
          <div class="row">
            <div class="col-12">
              <input type="submit" name="registerApplicant" value="Register" class="btn btn-primary btn-lg px-5" name="submit">
              <button type="button" class="btn btn-secondary btn-lg px-5" onclick="toggleLogin()">Log In</button>
            </div>
            </div>
        </form>
      </div>
    </div>
	</div>
  <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#51be78"/></svg></div>
  <script src="../js/jquery-3.3.1.min.js"></script>
  <script src="../js/jquery-migrate-3.0.1.min.js"></script>
  <script src="../js/jquery-ui.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/owl.carousel.min.js"></script>
  <script src="../js/jquery.stellar.min.js"></script>
  <script src="../js/jquery.countdown.min.js"></script>
  <script src="../js/bootstrap-datepicker.min.js"></script>
  <script src="../js/jquery.easing.1.3.js"></script>
  <script src="../js/aos.js"></script>
  <script src="../js/jquery.fancybox.min.js"></script>
  <script src="../js/jquery.sticky.js"></script>
  <script src="../js/jquery.mb.YTPlayer.min.js"></script>
  <script src="../js/main.js"></script>
</body>
</html>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
<script>
    $("#registerForm").hide()
    $("#registerForm").validate({
      rules: {
        fname: {
          required: true
        },
        lname: {
          required: true
        },
        email: {
          required: true,
          email: true
        },
        password: {
          required: true
        }
      }
    });
    $("#registerForm").validate();

    $("#registerForm").submit(function(e) {
        e.preventDefault();
        if ($("#registerForm").valid()) {
          data = $("#registerForm").serializeArray();
          $.post('register_applicant.php', data, function(response) {
            console.log(response);
            data = JSON.parse(response);
            toggleLogin();
            $("#loginForm").prepend("<div class='alert alert-danger' role='alert'>You have been registered with the ID " + data.id +  ". Remember your ID! Login and start your application.</div>")
            $("#loginForm input[name='username']").val(data.id);
            // $("#loginForm input[name='password']").val(data.pword);
          });
        }
        return false;
    })

    function toggleRegister() {
      console.log('working');
      $("#loginForm").hide();
      $("#registerForm").show();
    }
    function toggleLogin() {
      $("#loginForm").show();
      $("#registerForm").hide();
    }
</script>
