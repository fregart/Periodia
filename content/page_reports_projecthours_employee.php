<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>
<?php 
    if (isset($_GET['setUserID'])) {
        $cuserID = $_GET['setUserID'];
    } else {
        $cuserID = $_SESSION['user_ID'];                
    }    

    if (isset($_GET['setProjectID'])) {
        $cprojectID = $_GET['setProjectID'];
    }
?>



<div class="container mt-4">
    <div class="row">
        <div class="col-sm-12">

            <p class="h4">Timmar per anställd</p>
            <br />


            <form>
                <input type="hidden" name="action" value="searchMyHours" />

                <div class="form-group row">
                    <label for="employeeInput" class="col-sm-2 col-form-label">Anställd: </label>
                    <div class="col-sm-4">
                        <select class="form-control form-control-sm" name="employeeInput" id="employeeInput">
                            <?php                                
                                getEmployeeSelectedList($cuserID);                                                                                                                                                                                                                    
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="projectInput" class="col-sm-2 col-form-label">Projekt:</label>
                    <div class="col-sm-4">
                        <select class="form-control form-control-sm" name="projectInput" id="projectInput">
                        <option value="">-- Välj --</option>
                            <?php                                
                                getAllProjectsSelectList($cprojectID);
                            ?>
                        </select>
                    </div>
                </div>

               
            </form>


            <div>
           

            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th scope="col">Projekt</th>
                        <th scope="col">Eget-ID</th>
                        <th scope="col">Tidsram</th>
                        <th scope="col" class='text-right'>Timmar</th>
                    </tr>
                </thead>
                <tbody>                    

                    <?php                     
                        if (isset($_GET['setProjectID']))
                        {
                            getProjectReportEmployeeList($cuserID, $cprojectID);                        
                        }
                    ?>

                </tbody>
            </table>


            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-primary" title='Stäng'>Stäng</button>
                        </form>
                    </div>
                </div>
            </div>
            

        </div>
    </div>
</div>
<script>

    // project and user listener on change
    $("#employeeInput, #projectInput").change(function() {        
        
        var $userid = $("#employeeInput").children("option:selected").val();    
        var $projectid  = $("#projectInput").children("option:selected").val();

        var $file = 'page_reports_projecthours_employee' + '.php?setUserID='+ $userid +'&setProjectID=' + $projectid;
        var $path = 'content/';

        if ($userid != "" && $projectid != "" ) {
            $('#page-content').load($path + $file);    
        }
          
    });

    // cancel button listener
    $(".btn-primary").click(function() {
        $('#page-content').load('content/page_reports.php');
    });

</script>