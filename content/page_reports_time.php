<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>
<?php 
    if (isset($_GET['setUser'])) {
        $cuserID = $_GET['setUser'];
    } else {
        $cuserID = $_SESSION['user_ID'];                
    }    

    if (isset($_GET['setYear'])) {
        $currentYear = $_GET['setYear'];
    }else {
        $currentYear = getCurrentYear();
    }

?>

<div class="container mt-4">
    <div class="row">
        <div class="col-sm">

            <p class="h4">Tidrapport</p>
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

                <div class="form-group row">
                    <label for="yearInput" class="col-sm-2 col-form-label">År:</label>
                    <div class="col-sm-4">
                        <select class="form-control form-control-sm" name="yearInput" id="yearInput">
                            <?php
                            if (!isset($_GET['setYear'])) {
                                echo "<option value='2020'>2020</option>";
                                echo "<option selected value='2021'>2021</option>";
                            } else {
                                if ($_GET['setYear'] == 2020) {
                                    echo "<option selected value='" . $_GET['setYear'] . "'>" . $_GET['setYear'] . "</option>";
                                    echo "<option value='2021'>2021</option>";
                                }else {
                                    echo "<option value='2020'>2020</option>";
                                    echo "<option selected value='" . $_GET['setYear'] . "'>" . $_GET['setYear'] . "</option>";
                                };                            
                            }                                                                                                                    
                        ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="monthInput" class="col-sm-2 col-form-label">Månad:</label>
                    <div class="col-sm-4">
                        <select class="form-control form-control-sm" name="monthInput" id="monthInput">
                            <?php
                                $row_month = getMonthNameSelectedList();
                                for ($i=1; $i <13; $i++) {
                                    if (isset($_GET['setMonth'])) {
                                        if ($_GET['setMonth'] == $i) {
                                            echo "<option selected value='" . $_GET['setMonth'] . "'>" . $row_month[$i] . "</option>";
                                            $cmonth = $_GET['setMonth'];
                                        }else {
                                            echo "<option value='" . $i . "'>" . $row_month[$i] . "</option>";
                                        }
                                        
                                    }else {
                                        if (getCurrentMonth() == $i) {
                                            echo "<option selected value='" . $i . "'>" . $row_month[$i] . "</option>";
                                            $cmonth = $i;
                                        } else {
                                            echo "<option value='" . $i . "'>" . $row_month[$i] . "</option>";
                                        }                                                                                
                                    }
                                    
                                    
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </form>


            <!-- Print area -->
            <div id="printableArea" class="border border-dark">
                <!-- Get worked hours for user -->
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <td scope="col" style='border-top:0;' align="center" colspan="5">
                                <div class="h3">Tidrapportering</div>
                                <div class="h6"><?php echo getMonthFullName($cmonth) ?>, <?php if (isset($_GET['setYear'])) {
                                                                                                    echo $_GET['setYear'];
                                                                                                } else {
                                                                                                    echo $currentYear;
                                                                                                }?>
                                </div>
                                <div class="h5"><?php echo $_SESSION['user_company'] ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col" style='border-top:0;'>

                                <table class="table table-sm">
                                    <tr>
                                        <td style='border-top:0;' class="font-weight-bold p-2">Namn:</td>
                                    </tr>
                                    <tr>
                                        <td style='border-top:0;' class="font-weight-bold p-2 text-nowrap">
                                            <?php echo getUserFullName($cuserID) ?></td>
                                    </tr>
                                </table>

                            </td>
                            <td scope="col" style='border-top:0;'></td>
                            <td scope="col" style='border-top:0;'></td>
                            <td scope="col" style='border-top:0;'></td>
                            <td scope="col" style='border-top:0;'></td>
                        </tr>
                        <tr>
                            <th scope="col">Datum</th>
                            <th scope="col" class="text-center">Från</th>
                            <th scope="col" class="text-center">Till</th>
                            <th scope="col" class="text-center">Rast</th>
                            <th scope="col" class="text-center">Summa</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php                                                   
                             $disableNotesLink = false;
                             getWorkedHoursForReport($cuserID, $currentYear, $cmonth, $disableNotesLink);                                                                                                                
                        ?>

                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">Totalt antal timmar:</th>
                            <th scope="col" class="text-center"><?php echo getMonthTotalHours();?></th>
                        </tr>
                    </tbody>
                </table>

                <!-- Get absence hours for user -->                
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <td scope="col" style='border-top:0;' align="center" colspan="5">
                                <div class="h4">Frånvaro</div>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col" style='border-top:0;'></td>
                            <td scope="col" style='border-top:0;'></td>
                            <td scope="col" style='border-top:0;'></td>
                            <td scope="col" style='border-top:0;'></td>
                            <td scope="col" style='border-top:0;'></td>
                        </tr>
                        <tr>
                            <th scope="col">Typ</th>
                            <th scope="col" class="text-center">Från</th>
                            <th scope="col" class="text-center">Till</th>
                            <th scope="col" class="text-center">Tim /dag</th>
                            <th scope="col" class="text-center">% /dag</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php                                                   
                             $disableNotesLink = false;
                             getAbsenceHoursForReport($cuserID, $currentYear, $cmonth, $disableNotesLink);
                        ?>

                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col" class="text-center"></th>
                        </tr>
                    </tbody>
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
// employee, year, and month select listener on change
$("#employeeInput, #yearInput, #monthInput").change(function() {

    var $cuser = $("#employeeInput").children("option:selected").val();
    var $cyear = $("#yearInput").children("option:selected").val();
    var $cmonth = $("#monthInput").children("option:selected").val();

    var $file = 'page_reports_time' + '.php?setYear=' + $cyear + '&setMonth=' + $cmonth + '&setUser=' + $cuser;
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
    showHoursDivs($(this).attr("id"));
})

function showHoursDivs(callerId) {
    $(".notescontent", "#" + callerId + "hour").toggle();
}

// click listener to view notes
$(".absenceDiv>td>div>a").click(function() {
    showAbscDivs($(this).attr("id"));
})

function showAbscDivs(callerId) {
    $(".notescontent", "#" + callerId + "absc").toggle();
}


// cancel button listener
$(".btn-primary").click(function() {
    $('#page-content').load('content/page_reports.php');
});
</script>