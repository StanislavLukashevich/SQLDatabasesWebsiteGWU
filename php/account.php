<!DOCTYPE html>
<html lang="en">

<style>
  /* .not-nav {
    margin-top: 2%;
  } */

</style>

<head>
  <title>Account Info - Farm Fresh Regs</title>
  <?php require_once ('header.php'); ?>
</head>

<?php
    session_start();
    include('connectvars.php');
	
	if (isset ($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		$id = $_SESSION['id'];
	}

    if(!isset($id)){ // If user is not logged in redirect to login
        header("Location: login.php");
    }

    $fNameError = $lNameError = $addrError = $emailError = $currentPassError = $newPassError = $newPassConfirmError =  "" ;
    $submissionValid = false;
    $showSuccessMsg = false;

    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $user_userTable = mysqli_real_escape_string($dbc, trim($userTable));

    $account_info_query = "SELECT fname, lname, address, email FROM personal_info WHERE user_id= $id ";

    $data = mysqli_query($dbc, $account_info_query);

    $accountInfo = mysqli_fetch_array($data);

    $fnameCurrent = $accountInfo['fname'];
    $lnameCurrent = $accountInfo['lname'];
    $emailCurrent = $accountInfo['email'];
    $addressCurrent = $accountInfo['address'];

    $requiredField = " * Required Field ";
    $invalidEntry = " * Invalid Entry ";

    if(isset($_POST['submit'])){
        $emailValid = false;
        $fnameValid = false;
        $lnameValid = false;
        $addrValid = false;

        // Check that inputted first name is valid
        if (empty($_POST["fname"])) {
            // First name was empty  - throw error
            $fNameError  = $requiredField;
            $fnameValid = false;
        } else {
            if(preg_match("/^[a-zA-Z ]*$/",$_POST['fname'])) {
                $fnameValid = true;
                $fnameCurrent = $_POST['fname'];
            } else {
                $fNameError = $invalidEntry;
            }
        }

        // Check that inputted last name is valid
        if (empty($_POST['lname'])) {
            // Last name was empty  - throw error
            $lNameError  = $requiredField;
            $lnameValid = false;
        } else {
            if(preg_match("/^[a-zA-Z ]*$/",$_POST['lname'])) {
                $lnameValid = true;
                $lnameCurrent = $_POST['lname'];
            } else {
                $lNameError = $invalidEntry;
            }
        }

        // Check that inputted email is valid
        if (empty($_POST['email'])) {
			// If current email is empty, this is valid	
			if (empty ($emailCurrent)) {
				$emailValid = true;
			} else { // Else, user must enter a valid email
				$emailValid = false;
				$emailError = $requiredField;
			}
        } else {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $emailValid = true;
                $emailCurrent = $_POST['email'];
            } else {
                $emailError = $invalidEntry;
            }
        }

        // Check that inputted address is valid
        if (empty($_POST['address'])) { 
			// If current address is empty, this is valid	
			if (empty ($addressCurrent)) {
				$addrValid = true; 
			} else { // Else, user must enter a valid address
				$addressValid = false;
				$addressError = $requiredField;
			}
        } else {
            if (preg_match("/^[a-zA-Z0-9,.!? ]*$/", $_POST['address'])) { 
                $addrValid = true;
                $addressCurrent = $_POST['address'];
            } else {
                $addrError = $invalidEntry;
            }
        }

        if ($fnameValid && $lnameValid && $emailValid && $addrValid) {
            $submissionValid = true;
        }
        
        if ($submissionValid) {
            
            $showSuccessMsg = true;

            $infoUpdatedMsg = "Account Information Updated Succesfully";
            
            $fname = mysqli_real_escape_string($dbc, trim($_POST['fname']));
            $lname = mysqli_real_escape_string($dbc, trim($_POST['lname']));
            $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
            $address = mysqli_real_escape_string($dbc, trim($_POST['address']));
            
            $query = "UPDATE personal_info SET fname='$fname', lname='$lname'";

			if (!empty ($email)) {
				$query = $query . ", email='$email'";
			}

			if (!empty ($address)) {
				$query = $query . ", address='$address'";
			}

			// Add the where clause
			$query = $query . " WHERE user_id='$id';";

            mysqli_query($dbc, $query);
            
            if (!mysqli_query($dbc, $query)) {
                echo "Error: " .$query . "<br/>" . mysqli_error($dbc);
                $showSuccessMsg = false;
                $infoUpdatedMsg = "Error: Update was not processed. Contact an administrator.";
            }
        }
    }
    mysqli_close($dbc);
?>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

    <div class="site-wrap">

        <div class="">
            <div class="container not-nav">

                <?php
        $empty_string = "";

        if ($submissionValid && $showSuccessMsg) {
           echo "<div class='alert alert-success' role='alert'>
                    $infoUpdatedMsg
                </div>";
        } else if ($submissionValid && !$showSuccessMsg) {
            echo "<div class='alert alert-danger' role='alert'>
                    $infoUpdatedMsg
                 </div>";
        }

		if (isset ($_GET['id'])) {
			$link = "account.php?id=" . $_GET['id'];
		} else {
			$link = "account.php";
		}

        ?>
                <form method="post" class="card p-5 mt-4" action="<?php echo $link; ?>">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="fname">First Name</label><span
                                class="text-danger"><?php echo $fNameError;?></span>
                            <?php echo '<input type="text" id="fname" name="fname" class="form-control form-control-lg text-muted" value="'.$fnameCurrent.'">';?>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="lname">Last Name</label><span
                                class="text-danger"><?php echo $lNameError;?></span>
                            <?php echo '<input type="text" id="lname" name="lname" class="form-control form-control-lg text-muted" value="'.$lnameCurrent.'">';?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="email">Email Address</label><span
                                class="text-danger"><?php echo $emailError;?></span>
                            <?php echo '<input type="text" id="email" name="email" class="form-control form-control-lg text-muted" value="'.$emailCurrent.'">';?>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="address">Address</label><span
                                class="text-danger"><?php echo $addrError;?></span>
                            <?php echo '<input type="text" id="address" name="address" class="form-control form-control-lg text-muted" value="'.$addressCurrent.'">';?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" value="Update Account Info" name="submit"
                                class="btn btn-primary btn-lg px-5">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>
