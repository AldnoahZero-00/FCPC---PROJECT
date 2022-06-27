	<?php

	if(isset($_GET['userid']))
    {
       	$userid = $_GET['userid'];
        
        // GET STUDENT & CONTACT INFORMATION  

        $getprofile = mysqli_query($dbConn, "SELECT * FROM school_enrollment_pre_registration WHERE schlenrollprereg_id = '$userid'");
		$profile    = mysqli_fetch_array($getprofile);

		$get_acad_lvl = mysqli_query($dbConn, 
			"SELECT * FROM school_academiC_level WHERE schlacadlvl_id = ". $profile['acadlvl_id']);
		$acad_lvl     = mysqli_fetch_array($get_acad_lvl);

		$get_acad_yrlvl = mysqli_query($dbConn, 
			"SELECT * FROM school_academiC_year_level WHERE schlacadyrlvl_id = ". $profile['acadyrlvl_id']);
		$acad_yrlvl     = mysqli_fetch_array($get_acad_yrlvl);

		$get_acad_crse = mysqli_query($dbConn, 
			"SELECT * FROM school_academiC_course WHERE schlacadcrse_id = ". $profile['acadcrse_id']);
		$acad_crse     = mysqli_fetch_array($get_acad_crse);

		// GET PROVINCE 

		$get_pres_loc_prov = mysqli_query($dbConn, 
			"SELECT * FROM philippine_area_location_province WHERE philarealocprov_id = ". $profile['philarealocprov_present_id']);
		$pres_loc_prov  = mysqli_fetch_array($get_pres_loc_prov);

		$get_perma_loc_prov = mysqli_query($dbConn, 
			"SELECT * FROM philippine_area_location_province WHERE philarealocprov_id = ". $profile['philarealocprov_permanent_id']);
		$perma_loc_prov  = mysqli_fetch_array($get_perma_loc_prov);

		// GET MUNICIPALLITY

		$get_pres_loc_mun = mysqli_query($dbConn, 
			"SELECT * FROM philippine_area_location_municipality WHERE philarealocmun_id = ". $profile['philarealocmun_present_id']);
		$pres_loc_mun  = mysqli_fetch_array($get_pres_loc_mun);

		$get_perma_loc_mun = mysqli_query($dbConn, 
			"SELECT * FROM philippine_area_location_municipality WHERE philarealocmun_id = ". $profile['philarealocmun_permanent_id']);
		$perma_loc_mun  = mysqli_fetch_array($get_perma_loc_mun);

		// GET BARANGAY

		$get_pres_loc_brgy = mysqli_query($dbConn, 
			"SELECT * FROM philippine_area_location_barangay WHERE philarealocbrgy_id = ". $profile['philarealocbrgy_present_id']);
		$pres_loc_brgy  = mysqli_fetch_array($get_pres_loc_brgy);

		$get_perma_loc_brgy = mysqli_query($dbConn, 
			"SELECT * FROM philippine_area_location_barangay WHERE philarealocbrgy_id = ". $profile['philarealocbrgy_permanent_id']);
		$perma_loc_brgy  = mysqli_fetch_array($get_perma_loc_brgy);


	}
?>