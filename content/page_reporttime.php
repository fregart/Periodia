<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>
<?php


// get current day if no date is set
if(isset($_GET['setDate'])){
    $setDate = $_GET['setDate'];
}else {
    $setDate = getCurrentDate();
}

// default form values at start and then on
// select change update form fields if there is
// any working hours in database else
// set default hours to 00
if(isset($_GET['setProjectID'])){    
    
    $setProjectID = $_GET['setProjectID'];
    
    if (!$row = getWorkHours($setDate, $setProjectID)){
        // default values
        $row['wo_starttime'] = "00:00";
        $row['wo_endtime'] = "00:00";
        $row['wo_rest'] = "00:00";
        $row['wo_notes'] = "";
    }         

}else{
    // default values
    $row['wo_starttime'] = "07:00";
    $row['wo_endtime'] = "16:00";
    $row['wo_rest'] = "01:00";
    $row['wo_notes'] = "";
}
?>

<!-- Rapportera timmar -->

<div class="container-fluid">
    <h4 class="mt-4">Rapportera timmar</h4>
    <br />

    <div class="col-sm-12 col-m-8 col-lg-4">
        <div class="card" style="background-color:#dfe5e8;">
            <div class="card-body">       
        
                <form method="post" enctype='multipart/form-data'>         
                    <input type="hidden" name="action" value="reportTime" />     
                    <div class="row w-50">
                        <div class="form-group">
                            <div class="col">
                                <label for="datumInput">Datum</label>                            
                                <input type="date" class="form-control" id="datumInput" name="datumInput" value="<?php echo $setDate; ?>" />
                            </div>
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="projectInput">Projekt</label> <!--<i class="far fa-question-circle small"></i>-->
                                <select class="form-control" id="projectInput" name="projectInput">
                                    <?php getAllProjectsSelectList($setProjectID);?>                    
                                </select>
                            </div>
                        </div>                    
                    </div> 

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="timefromInput">Från</label>
                                <input type="time" class="form-control" id="timefromInput" name="timefromInput" value="<?php echo $row['wo_starttime']; ?>" />
                            </div>
                        </div>                    
                        <div class="col">
                            <div class="form-group">
                                <label for="timetoInput">Till</label>
                                <input type="time" class="form-control" id="timetoInput" name="timetoInput" value="<?php echo $row['wo_endtime']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="breakInput">Rast</label>
                                <input type="time" class="form-control" id="breakInput" name="breakInput" value="<?php echo $row['wo_rest']; ?>" />
                            </div>
                        </div>                    
                        <div class="col">
                            <div class="form-group">
                            <label for="calcInput">Timmar</label>                   
                            <input type="text" class="form-control font-weight-bold text-success" id="calcInput" name="calcInput" value="" readonly />                                                
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <hr>
                        </div>                    
                    </div>                                 

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for='notesTextarea'>Noteringar</label>
                                <textarea class='form-control' name='notesTextarea' id='notesTextarea' rows='5'></textarea>
                            </div>
                        </div>                    
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">                                
                                <label for='file'>Bilder</label>
                                <input type='file' name='fileToUpload[]' class='form-control-file' id='fileToUpload'
                                    multiple='multiple'>                         
                            </div>
                        </div>                    
                    </div>
                    
                    <br>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success" title='Spara'>Spara</button>
                                <button type="button" class="btn btn-primary" title='Avbryt'>Avbryt</button>                          
                            </div>                                    
                        </div>
                    </div>
                </form>
        
            </div>
        </div>
    </div>
</div>

<script>


    // calc workhours after loading page
    calcTime();
    
    // calc workhours
    function calcTime() {
        var timefrom = $("#timefromInput").val();
        var timeto = $("#timetoInput").val();
        var timebreak = $("#breakInput").val();    
    
        hours = timeto.split(':')[0] - timefrom.split(':')[0] - timebreak.split(':')[0],
        minutes = timeto.split(':')[1] - timefrom.split(':')[1] - timebreak.split(':')[1];

        minutes = minutes.toString().length<2?'0'+minutes:minutes;        
        if(minutes<0){ 
            hours--;
            minutes = 60 + minutes;
        }
        hours = hours.toString().length<2?'0'+hours:hours;
        
        // update calc field        
        $('#calcInput').val(hours + ':' + minutes);
        $('#calcInput').fadeOut(100).fadeIn(100).fadeOut(400).fadeIn(800); 
    };             

    $("input").change(function(){
        calcTime();        
    });

    // cancel button listener
    $(".btn-primary").click(function(){
        $('#page-content').load('content/page_schema.php');
    });
    
    // project select listener on change    
    $("#projektInput").change(function() {

        var $csetdate = $('#datumInput').val();
        var $selectedVal = $(this).children("option:selected").val();   
        
        var $file = 'page_reporttime' + '.php?setDate='+ $csetdate +'&setProjectID=' + $selectedVal;
        var $path = 'content/';

        $('#page-content').load($path + $file);            

    });

    // disable save button if there is no project
    var $buttonDisableTest = $('#projektInput').children("option").val();
    if ($buttonDisableTest == 0) {
        $('.btn-success').prop("disabled",true);
    }
    
</script>
