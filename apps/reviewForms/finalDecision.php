<?php
        require_once('../includes/utils.php');
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $applicationID = $_GET['applicationID'];
        $query = "SELECT userID FROM application_form WHERE applicationID = '$applicationID'";

        $result = mysqli_query($dbc, $query);
        $info = mysqli_fetch_array($result);

        $applicantID = $info['userID'];

?>

<h2 align="center">Final Decision</h2>
<?php echo"<form method='post' action='./reviewForms/submitDecision.php?applicantID=$applicantID'>"; ?>

        <label for="rating">Final Decision</label>
        <select id="rating" name="rating">
                <option value="4">Reject</option>
                <option value="2">Admit Without Aid</option>
                <option value="3">Admit With Aid</option>
        </select><br/>

        <label for="reasons">Recommended Advisor ID</label>
        <input type="text" name="advisor" id="advisor" required><br/>

	<button name="submit" class="btn btn-primary">Submit</button>
</form>

