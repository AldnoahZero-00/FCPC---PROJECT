<?php
	include('controller/class/configuration/connection.php');

	if(isset($_SESSION["userid"]))
	{
		$userid = $_SESSION['userid'];
	} 
	else 
	{
		$userid = 0;
	}
	$qryreg = "SELECT `reg`.`schlenrollprereg_regdate` `REG_DATE`,
					  UPPER(CONCAT(`reg`.`schlenrollprereg_lname`, ', ', `reg`.`schlenrollprereg_fname` , ' ' , `reg`.`schlenrollprereg_mname`)) `NAME`,
					  UPPER(`lvl`.`schlacadlvl_name`) `LVL_NAME`, 
					  UPPER(`yrlvl`.`schlacadyrlvl_name`) `YRLVL_NAME`, 
					  UPPER(`crse`.`schlacadcrse_code`) `CRSE_NAME`, 
					  `reg`.`schlusr_id` `USER_ID`,
					  `reg`.`schlenrollprereg_id` `VIEW`,
					  `reg`.`schlenrollprereg_id` `PROCESS`, 
					  `reg`. schlenrollprereg_verification `VERIFY`,
					  `lvl`.`schlacadlvl_name` `level` 
					FROM `school_enrollment_pre_registration` `reg`
						LEFT JOIN `school_academic_level` `lvl`
							ON `reg`.`acadlvl_id`=`lvl`.`schlacadlvl_id`
						LEFT JOIN `school_academic_year_level` `yrlvl`
							ON `reg`.`acadyrlvl_id`=`yrlvl`.`schlacadyrlvl_id`
						LEFT JOIN `school_academic_course` `crse`
							ON `reg`.`acadcrse_id`=`crse`.`schlacadcrse_id`
						LEFT JOIN `school_users` `usr`
							ON `reg`.`schlusr_id`=`usr`.`schlusr_id`"; 

	$rsreg = $dbConn->query($qryreg);
	$fetchDatareg = $rsreg->fetch_ALL(MYSQLI_ASSOC);
	
	$qryuser = "SELECT `schlusr_lname` `NAME`,
				       `schlusr_id` `USER_ID`
				FROM `school_users`
					WHERE `schlusr_status` = 1 
					AND `schlusr_isactive` = 1 ";
	$rsuser = $dbConn->query($qryuser);
	$fetchDatauser = $rsuser->fetch_ALL(MYSQLI_ASSOC);





	
?>
	<link href="tool/bootstrap-5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
	<script src="tool/bootstrap-5.0.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="tool/jquery-3.6.0.min.js"></script>
	<body>
  	<div class="container">
  		<br>
          <h1 align="center">FIRST CITY PROVIDENTIAL COLLEGE</h1>
          <h2 align="center">ONLINE REGISTRATION</h2>
        <br>
  	</div>
  	<div class="container">
  		<div class="row">
  			<div class="col-md-2">
  				
  			<!--
  				<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Display Data</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
						<li><a class="dropdown-item" href="#">25</a></li>
						<li><a class="dropdown-item" href="#">50</a></li>
						<li><a class="dropdown-item" href="#">100</a></li>
					</ul>
				</div>
			-->
  			</div>
  			<div class="col-md-2"></div>
  			<div class="col-md-2"></div>
  			<div class="col-md-2"></div>
			<div class="col-md-4">
			<!--	
			<form class="d-flex">
			  <input id="searchtxt" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
			  <button class="btn btn-outline-success" type="submit">Search</button>
			</form>
		-->
  			</div>
  		</div>
  	</div>
  	<br>
    <div class="container" id="table-list">
		<div id="prereg-data"></div>
	<?php
		$createTable  = "<table id='regtable' class='table caption-top table-hover'>";
		$createTable .= "<thead class='table-dark'>";
		$createTable .= "<tr>";
		$createTable .= "<th scope='col'>Timestamp</th>";
		$createTable .= "<th scope='col'>Student Name</th>";
		$createTable .= "<th scope='col'>Level</th>";
		$createTable .= "<th scope='col'>Grade Level</th>";
		$createTable .= "<th scope='col'>Course Strand</th>";
		$createTable .= "<th scope='col'>Assigned to</th>";
		$createTable .= "<th scope='col'>Processed</th>";
		$createTable .= "<th scope='col' colspan=2>Actions</th>";
		$createTable .= "</tr>";
		$createTable .= "</thead>";
		$createTable .= "<tbody>";
		$createTable .= "<div></div>";
		
		foreach($fetchDatareg as $regitem)
		{	
			
			$createTable .= "<tr>";
			$createTable .= "<td>".$regitem['REG_DATE']."</td>";
			$createTable .= "<td>".$regitem['NAME']."</td>";
			$createTable .= "<td>".$regitem['LVL_NAME']."</td>";
			$createTable .= "<td>".$regitem['YRLVL_NAME']."</td>";
			$createTable .= "<td>".$regitem['CRSE_NAME']."</td>";

			$createTable .= "<td>";
			$createTable .= "<div class='dropdown'>";
			$createTable .= "<select id='list' name='list' class='form-control dropdown'>";
			$createTable .= "<option value='0'>Unassigned</option>";
			foreach($fetchDatauser as $useritem)
			{
					$createTable .= "<option value='".$useritem['USER_ID']."'>".$useritem['NAME']."</option>";
			}
			$createTable .= "</select>";
			$createTable .= "</div>";
			$createTable .= "</td>";

			$createTable .= "<td>";
			
			if($regitem['VERIFY'] == 2)
			{
				$createTable .= "<button type='button' class='btn btn-success'>Processed</button>";
			}

			$createTable .= "</td>";

			$createTable .= "<td>";
			$createTable .= "<div class='btn-group' role='group' aria-label='Basic example'>";
			$createTable .= "<a href='enrollmentregistrationform.php?userid=".$regitem['VIEW']."' target = '_blank'><button type='button' class='btn btn-primary'>View Profile</button></a>";
			$createTable .= "<input type='hidden' id='".$regitem['VIEW']."' name='prereg_id' value='".$regitem['VIEW']."'>";
			if($regitem['VERIFY'] == 1)
			{
				$createTable .= "<td>";
				$createTable .= "<a href='controller/student_process_verify.php?prcss_id=".$regitem['VIEW']."'><button type='button' class='btn btn-secondary'>Verify Profile</button></a>";
				$createTable .= "<input type='hidden'  id=".$regitem['PROCESS']."' name='submit' value='".$regitem['PROCESS']."'>";
				$createTable .= "</td>";
			}
			

			$createTable .= "</div>";
			$createTable .= "</td>";
			$createTable .= "</tr>";
		}
		$createTable .= "</tbody>";
		$createTable .= "</table>";
			
		echo $createTable;
		$rsreg->close();
		//$dbConn->close();
	?>
    </div>	
    <div class="container">
    	<div class="row">
    		<div class="col-md-4"></div>
    		<div class="col-md-4">
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<li class="page-item"><a class="page-link" href="#">Previous</a></li>
						<li class="page-item"><a class="page-link" href="#">1</a></li>
						<li class="page-item"><a class="page-link" href="#">2</a></li>
						<li class="page-item"><a class="page-link" href="#">3</a></li>
						<li class="page-item"><a class="page-link" href="#">Next</a></li>
					</ul>
				</nav>
			</div>
			<div class="col-md-4"></div>
    	</div>
    </div>
	<script>
	$(document).ready(function(){
		var table = $('#regtable').DataTable();
		var searchtxt = $('#searchtxt').val();
		var filteredData = table
			.columns( 1 )
			.data()
			.flatten()
			.filter( function ( value, index ) {
				return value = searchtxt ? true : false;
		});
		/*$('.list li').click(function(e) {
			var clicked_element_value = $(this).attr("value");
			var parent = $(this).parent().attr('name');
			alert($("#" + parent).val(clicked_element_value));
		});*/

	});
  </script>
  </body>
 
