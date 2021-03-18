<!DOCTYPE html>
<html lang="en">
<head>
  
</head>

<?php require_once ('header.php'); ?>

<body>
  <!-- Navigation -->
  <!-- Page Content -->
  <div class="site-section">
  <div class="container">
  <div class="row justify-content-center">
                <div class="col-md-5">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="address">Address:</label>
                            <input type="text" id="address" name="address" class="form-control form-control-lg">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="city">City:</label>
                            <input type="text" id="city" name="city" class="form-control form-control-lg">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="state">State:</label>
                            <input type="text" id="state" name="state" class="form-control form-control-lg">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="zipcode">Zip:</label>
                            <input type="text" id="zipcode" name="zipcode" class="form-control form-control-lg">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" value="Update address" class="btn btn-success btn-lg px-5" name="submit">
                        </div>
                    </div>
                </form>
                </div>
            </div>
	</div>

</body>
</html>
