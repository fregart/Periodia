<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>
<?php 
    if (isset($_GET['setUser'])) {
        $cuserID = $_GET['setUser'];
    } else {
        $cuserID = $_SESSION['user_ID'];                
    }    
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-sm">

            <p class="h4">Registerutdrag (GDPR)</p>
            <br />

            <div class="alert alert-secondary" role="alert">
                Om en användare vill veta vilka personliga uppgifter som finns lagrade i databasen går det skriva ut en
                rapport om det här.
            </div>

            <br />

            <form>
                <input type="hidden" name="action" value="searchMyHours" />

                <div class="form-group row">
                    <label for="employeeInput" class="col-sm-2 col-form-label">Användare: </label>
                    <div class="col-sm-4">
                        <select class="form-control form-control-sm" name="employeeInput" id="employeeInput">
                            <?php                                
                                getEmployeeSelectedList($cuserID);                                                                                                                                                                                                                    
                            ?>
                        </select>
                    </div>
                </div>
            </form>



            <div id="printableArea" class="border border-dark">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <td scope="col" style='border-top:0;' align="center" colspan="5">
                                <div class="h3">Registerutdrag</div>

                                <div class="h5"><?php echo $_SESSION['user_company'] ?></div>
                                <div class="h6"><?php echo getCurrentDate()?></div>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col" style='border-top:0;' align="center" colspan="5">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col" style='border-top:0;' colspan="3">

                            <table class="table table-borderless"> 
                            <tbody>                               

                                <?php getUsersAllData($cuserID) ?>

                            </tbody>                               
                            </table>  

                            </td>

                        </tr>
                        <tr>
                            <td scope="col" style='border-top:0;' align="center" colspan="5">
                                <hr>
                            </td>
                        </tr>

                    </thead>

                </table>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-primary" title='Stäng'>Stäng</button>
                        <input type="button" class="btn btn-success mt-4 mb-4" onclick="printReport('printableArea')"
                            value="Skriv ut" />
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>





</div>
</div>
</div>
<script>
// employee select listener on change
$("#employeeInput").change(function() {

    var $cuser = $("#employeeInput").children("option:selected").val();    

    var $file = 'page_reports_registerextract' + '.php?setUser=' + $cuser;
    var $path = 'content/';

    $('#page-content').load($path + $file);

});

// print reports function
function printReport(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = $('body').html();

    document.body.innerHTML = printContents;

    window.print();

    $('body').html(originalContents);
}

// click listener to view notes
$(".workedHoursDiv>td>div>a").click(function() {
    showDivs($(this).attr("id"));
})

function showDivs(callerId) {
    $(".notescontent", "#" + callerId + "c").toggle();
}


// cancel button listener
$(".btn-primary").click(function() {
    $('#page-content').load('content/page_reports.php');
});
</script>