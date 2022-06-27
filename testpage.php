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
    $sql = "SELECT `reg`.`schlenrollprereg_regdate` `REG_DATE`,
        UPPER(CONCAT(`reg`.`schlenrollprereg_lname`, ', ', `reg`.`schlenrollprereg_fname` , ' ' , `reg`.`schlenrollprereg_mname`)) `NAME`,
        UPPER(`lvl`.`schlacadlvl_name`) `LVL_NAME`, 
        UPPER(`yrlvl`.`schlacadyrlvl_name`) `YRLVL_NAME`, 
        UPPER(`crse`.`schlacadcrse_code`) `CRSE_NAME`, 
            `reg`.`schlusr_id` `USER_ID`,
            `reg`.`schlenrollprereg_id` `VIEW`,
            `reg`.`schlenrollprereg_id` `PROCESS`, 
            `lvl`.`schlacadlvl_name` `level` 
        FROM `school_enrollment_pre_registration` `reg`
            LEFT JOIN `school_academic_level` `lvl`
                ON `reg`.`acadlvl_id`=`lvl`.`schlacadlvl_id`
            LEFT JOIN `school_academic_year_level` `yrlvl`
                ON `reg`.`acadyrlvl_id`=`yrlvl`.`schlacadyrlvl_id`
            LEFT JOIN `school_academic_course` `crse`
                ON `reg`.`acadcrse_id`=`crse`.`schlacadcrse_id`
            LEFT JOIN `school_users` `usr`
                ON `reg`.`schlusr_id`=`usr`.`schlusr_id`
            WHERE `reg`.`schlusr_id` "; 


    $qryuser = "SELECT `schlusr_lname` `NAME`,
                    `schlusr_id` `USER_ID`
                FROM `school_users`
                WHERE `schlusr_status` = 1 
                AND `schlusr_isactive` = 1 ";
    
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
            <table id='regtable' class='table caption-top table-hover'>
                <thead class='table-dark'>
                    <tr>
                        <th scope='col'>Timestamp</th>
                        <th scope='col'>Student Name</th>
                        <th scope='col'>Level</th>
                        <th scope='col'>Grade Level</th>
                        <th scope='col'>Course Strand</th>
                        <th scope='col'>Assigned to</th>
                        <th scope='col'>Processed</th>
                        <th scope='col'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <div>

                <?php 
                    $result = $dbConn->query($sql);
                    $count=0;
                    if ($result -> num_rows >  0) 
                    {
                        while ($row = $result->fetch_assoc()) 
                        {
                            $count=$count+1;
                ?>
                    <tr>
                        <td><?php echo $row["REG_DATE"]        ?></td>
                        <td><?php echo $row["NAME"]            ?></td>
                        <td><?php echo $row["LVL_NAME"]        ?></td>
                        <td><?php echo $row["YRLVL_NAME"]      ?></td>
                        <td><?php echo $row["CRSE_NAME"]       ?></td>
                        <td>
                            <select id='list' name='list' class='form-control dropdown'>
                                <option value='0'>Unassigned</option>
                                <?php
                                    $rsuser = $dbConn->query($qryuser);
                                    $count=0;

                                    if ($rsuser -> num_rows >  0) 
                                    {
                                        while ($rsuser_row = $rsuser->fetch_assoc()) 
                                        {
                                        $count=$count+1;
                                ?>  
                                    <option value='<?php echo $rsuser_row["USER_ID"]?>'><?php echo $rsuser_row["NAME"]?></option>
                                <?php
                                        }
                                    }
                                ?>    
                            </select>
                        </td>
                        <td>

                        </td>
                        <td>
                            <div class='btn-group' role='group' aria-label='Basic example'>
                                <a href='enrollmentregistrationform.php?userid="<?php echo $row["VIEW"]?>" target = '_blank'>
                                    <button type='button' class='btn btn-primary'>View Profile</button></a>
                                <input type='hidden' id='<?php echo $row["VIEW"]?>' name='prereg_id' value='<?php echo $row["VIEW"]?>'>

                                <button type='button' class='btn btn-danger' hidden>Process</button>
                                <input type='hidden' id='<?php echo $row["VIEW"]?>' name='prereg_id' value='".$regitem['PROCESS']."'>

                            </div>
                        </td>
                    </tr>
            <?php
                        }
                    }
            ?>
                    </div>
                </tbody>
            </table>

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

<script type="text/javascript">

$(document).ready(function() {
    $("#list").change(function(){
        $.ajax({
            type: 'POST',
            data:  {keyname:$('#list option:selected').val()}
            
        });
    });
});




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
 