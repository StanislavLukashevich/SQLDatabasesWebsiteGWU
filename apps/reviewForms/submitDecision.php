<!DOCTYPE HTML>

<html>

<?php
        require_once('../includes/utils.php');

        $fID = $_SESSION["id"];

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $applicantID = $_GET['applicantID'];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if (isset($_POST['rating'])) {
                        $final = $_POST['rating'];
                }
                else {
                        exit("Please enter a rating!");
                }

                if (isset($_POST['advisor'])) {
                        $advisor = $_POST['advisor'];
                        $insertDecision = "INSERT INTO final_decision VALUES ($fID, $applicantID, $final, $advisor)";
                        try {
                                try_insert($dbc, $insertDecision, "recommendation entered<br>");
                        }
                        catch (exception $e) {
                                if ($dbc->errno == 1264 || $dbc->errno == 1452) {
                                        exit("Your faculty ID ($fID) does not match anyone in our database. Please check it and try again.");
                                }
                                else {
                                        echo $dbc->errno;
                                        throw $e;
                                }
                        }

                        //update application from DB once decision is made
                        $updateQuery = "UPDATE application_form SET decision = $final WHERE userID = $applicantID";
                        try_query($dbc, $updateQuery, NULL);       
                }
                header("Location: ../index.php");
        }

?>

<html>

