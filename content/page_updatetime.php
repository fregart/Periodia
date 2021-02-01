<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>
<?php

if(isset($_GET['setWorkedID'])){    
    
    $workedID = $_GET['setWorkedID'];
    
    $sql = "SELECT *
    FROM
      tbl_workinghours a
    LEFT JOIN tbl_project b ON a.wo_projectID=b.pr_ID
    WHERE
      a.wo_ID = $workedID";
                    
    $result = mysqli_query($db,$sql);

    // print error message if something happend
    if (!$result) {
    printf('Error: %s\n', mysqli_error($db));        
    exit();
    }    

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
    }
    ?>

        <!-- update hours -->
        <div class="container-fluid">
            <h4 class="mt-4">Uppdatera timmar</h4>
            <br />

            <div class="col-sm-12 col-m-8 col-lg-4">
                <div class="card" style="background-color:#dfe5e8;">
                <div class="card-body">
                
                
                <form method="post">         
                <input type="hidden" name="action" value="updateTime" />     
                    <div class="row w-50">
                        <div class="form-group">
                            <div class="col">
                                <label for="datumInput">Datum</label>                            
                                <input type="date" class="form-control" id="datumInput" name="datumInput" value="<?php echo $row['wo_date']; ?>" />
                            </div>
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="projekInput">Projekt</label> <!--<i class="far fa-question-circle small"></i>-->
                                <select class="form-control" id="projektInput" name="projektInput">
                                    <?php getAllProjectsSelectList($row['pr_ID']);?>                    
                                </select>
                            </div>
                        </div>                    
                    </div> 

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="tidfrånInput">Från</label>
                                <input type="time" class="form-control" id="tidfrånInput" name="tidfrånInput" value="<?php echo $row['wo_starttime']; ?>" />
                            </div>
                        </div>                    
                        <div class="col">
                            <div class="form-group">
                                <label for="tidtillInput">Till</label>
                                <input type="time" class="form-control" id="tidtillInput" name="tidtillInput" value="<?php echo $row['wo_endtime']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="rastInput">Rast</label>
                                <input type="time" class="form-control" id="rastInput" name="rastInput" value="<?php echo $row['wo_rest']; ?>" />
                            </div>
                        </div>                    
                        <div class="col">
                            <div class="form-group">
                            <label for="calcInput">Timmar</label>                   
                            <input type="text" class="form-control font-weight-bold text-success" id="calcInput" name="calcInput" value="" />                                                
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
                                <label for="rastInput">Noteringar</label>
                                <textarea class="form-control" name="notesInput" rows="5"><?php echo $row['wo_notes']; ?></textarea>                         
                            </div>
                        </div>                    
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success" title='Spara'>Spara</button>
                                <button type="button" class="btn btn-primary" title='Avbryt'>Avbryt</button>
                                </form>
                            </div>
                    

                            <div class="col">
                                <form method="post">
                                
                                    <input type="hidden" name="action" value="deleteReport">
                                    <input type="hidden" name="removeThisID" value="<?php echo $workedID ?>">                                  
                                    <button type='submit' class='btn btn-danger' id='btndelete' title='Ta bort' disabled>Ta bort</button>                                  
                                    <div class='form-check'>
                                    <br>
                                    <input type='checkbox' class='form-check-input' id='enableCheck'>
                                    <label class='form-check-label' for='enableCheck'><p class='small'>Aktivera</p></label>
                                  
                                </form>
                            </div>
                        </div>
                
                

                    </div>
            

                </div>
                </div>

            </div>
        </div>

    
<?php
}else{
    echo "wew";
}
?>


    

<script>


    // calc workhours after loading page
    calcTime();
    
    // calc workhours
    function calcTime() {
        var timefrom = $("#tidfrånInput").val();
        var timeto = $("#tidtillInput").val();
        var timebreak = $("#rastInput").val();    
    
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
    
    // enables the delete button on checked
    $('#enableCheck').click(function () {
        
        if ($(this).is(':checked')) {
          $('#btndelete').removeAttr('disabled');
    
        } else {
          $('#btndelete').attr('disabled', true);
        }
    });
    
</script>
