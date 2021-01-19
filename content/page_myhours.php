<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>

<!-- Mina timmar -->
<section class="page-myhours">
    <div class="container-fluid custom-padding">
        <h4 class="mt-4">Mina timmar</h4>
        <br />

        <div class="col-sm-12 col-m-8 col-lg-4">

            <form>         
                <input type="hidden" name="action" value="searchMyHours" /> 


            
                <div class="form-group row">
                    <label for="yearInput" class="col-sm-2 col-form-label form-control-sm">År:</label>
                    <div class="col-sm-10">
                    <select class="form-control form-control-sm" style="width:80px;" name="yearInput" id="yearInput">
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                        </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <label for="monthInput" class="col-sm-2 col-form-label form-control-sm">Månad:</label>
                    <div class="col-sm-10">
                    <select class="form-control form-control-sm" style="width:80px;" name="monthInput" id="monthInput">
                            <?php
                                $row_month = getMonthNameSelectedList();
                                for ($i=1; $i <13; $i++) {
                                    if (isset($_GET['setMonth'])) {
                                        if ($_GET['setMonth'] == $i) {
                                            echo "<option selected value='" . $_GET['setMonth'] . "'>" . $row_month[$i] . "</option>";
                                        }else {
                                            echo "<option value='" . $i . "'>" . $row_month[$i] . "</option>";
                                        }
                                        
                                    }else {
                                        if (getCurrentMonth() == $i) {
                                            echo "<option selected value='" . $i . "'>" . $row_month[$i] . "</option>";
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


            <table class="table table-condensed full-width table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Datum</th>
                        <th scope="col">Från</th>
                        <th scope="col">Till</th>
                        <th scope="col">Rast</th>
                        <th scope="col">Timmar</th>       
                    </tr>   
                </thead> 
                <tbody>   
                    
                    <?php

                    if (isset($_GET['setMonth'])) {
                    $date   = ''. $_GET['setYear'] . '-' . $_GET['setMonth'] . '-01';
                    $end    = ''. $_GET['setYear'] . '-' . $_GET['setMonth'] . '-' . date('t', strtotime($date)); //get end date of month
                    } else {
                    $date   = ''. getCurrentYear() . '-' . getCurrentMonth() . '-01';
                    $end    = ''. getCurrentYear() . '-' . getCurrentMonth() . '-' . date('t', strtotime($date)); //get end date of month
                    }

                    while(strtotime($date) <= strtotime($end)) {
                        $dateID     = date('Y-m-d', strtotime($date));
                        $day_num    = date('d', strtotime($date));
                        $day_name   = date('l', strtotime($date));
                        $date       = date("Y-m-d", strtotime("+1 day", strtotime($date)));

                        // mark saturday and sunday with color
                        if ($day_name == 'Saturday' || $day_name == 'Sunday') {
                            echo "<tr id='$dateID' style='background-color: lightgray'>";
                        } else {
                            echo "<tr id='$dateID'>";
                        }
                        
                        echo "<th scope='row'>$day_num<br><span class='small'>".transDayName($day_name)."</span></th>";

                        getWorkedHours($dateID);
                        
                        echo "</tr>";
                    }
                    ?>        
                </tbody>
            </table>
    

        </div>
    </div>
</section>
<script>
    // month select listener on change    
    $("#monthInput").change(function() {
        
    var $cyear  = $("#yearInput").children("option:selected").val();
    var $cmonth = $(this).children("option:selected").val();   

    var $file = 'page_myhours' + '.php?setYear='+ $cyear +'&setMonth=' + $cmonth;
    var $path = 'content/';

    $('#page-content').load($path + $file);            

    });

    // day click listener
    $('tbody, tr').click(function (e) {
        e.preventDefault();   
        e.stopPropagation();              
        var $cdate = this.id;
        var $file = 'page_reporttime' + '.php?setDate=' + $cdate;
        var $path = 'content/';                  
                    
        $('#page-content').load($path + $file);                
    });

</script>


        
        
     