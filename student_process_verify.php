
<?php
	session_start();
    $dashboard = $_SESSION['DASHBOARD'];

	include('class/configuration/connection.php');



	// PROCESS STUDENT
	if(isset($_GET['prcss_id']))
    {
       	$userid = $_GET['prcss_id'];

       	$qry = "UPDATE school_enrollment_pre_registration 
       			SET schlenrollprereg_verification = 2 
       			WHERE schlenrollprereg_id = $userid";

        mysqli_query($dbConn, $qry);  

        echo "<script type='text/javascript'>alert('Student is Processed Successfully')</script>";
        echo "<script type='text/javascript'>location.href='../$dashboard'</script>";

    }

       // VERIFY STUDENT
    
?>