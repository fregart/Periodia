<?php
session_start();
require_once('../dbconnect.php');
require_once('../functions.php');

global $db;

  if (isset($_GET['projectID'])) {    
    $projectID= intval($_GET['projectID']);
    
  }

  $sql = "SELECT *
          FROM
            tbl_project
          LEFT JOIN tbl_status ON tbl_project.pr_status=tbl_status.st_ID
          WHERE
            tbl_project.pr_ID = $projectID";
                       
  $result = mysqli_query($db,$sql);
  
  // print error message if something happend
  if (!$result) {
      printf('Error: %s\n', mysqli_error($db));        
      exit();
  }    

  if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_array($result);
  ?>

<!-- Show project -->
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h4 class="mt-4"><?php echo ucfirst($row["pr_name"]) ?>
                <?php if ($row["pr_internID"]) {
            echo "(" . ucfirst($row["pr_internID"] . ")");
          }?>
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title"><strong>Projektinformation</strong></h6>




                    <div class="row">
                        <div class="col col-lg-2">

                            <span class="small">Startdatum: <br>
                                <?php echo $row["pr_startdate"]; ?>
                            </span>

                        </div>
                        <div class="col col-lg-2">

                            <span class="small">Slutdatum: <br>
                                <?php echo $row["pr_enddate"]; ?>
                            </span>


                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col col-lg-2">

                            <span class="small">Eget-ID: <br>
                                <?php echo $row["pr_internID"]; ?>
                            </span>

                        </div>
                        <div class="col col-lg-2">

                            <span class="small">Status:</span><br>
                            <span class="badge"
                                style="background-color:#<?php echo $row["st_hex"]?>;color:#FFFFFF;"><?php echo $row["st_name"]; ?></span>




                        </div>
                    </div>

                    <hr>

                    <p class="small"><strong>Beskrivning</strong></p>
                    <?php echo $row["pr_description"]; ?>

                    <hr>                                       
                   
                    <div class="form-group">
                    <form action="post">
                        <div class="row">
                            <div class="col">
                                <!-- Admin section -->
                                <button type="submit" class="btn btn-success">Redigera</button>
                                <input type="hidden" name="action" value="newProject" />   
                                <!-- End Admin section -->
                                <button type="button" class="btn btn-primary" id="btn-close" title='Avbryt'>Stäng</button>                                
                            </div>                    
                        </div>      
                    </form>                  
                    </div>
                    
                </div>

            </div>
        </div>
    </div>


    <p></p>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title"><strong>Inlägg</strong></h6>

                    <!-- Add new note section -->
                    <button class='btn btn-primary btn-sm' id='addnotesbutton'><i class='fa fa-plus-circle'></i> Nytt
                        inlägg</button>
                    <div id='addnotesdiv' style='display: none'>
                        <p></p>
                        <form method='post' enctype='multipart/form-data'>
                            <input type='hidden' name='action' value='addNotes'>
                            <input type='hidden' name='projectIDInput' value='<?php echo $row['pr_ID'] ?>'>
                            <div class='form-group'>
                                <label for='notesTextarea'>Skriv inlägg.</label>
                                <textarea class='form-control' name='notesTextarea' id='notesTextarea'
                                    rows='5'></textarea>
                            </div>

                            <div class='form-group'>
                                <label for='file'>Lägg till en eller flera bilder</label>
                                <input type='file' name='fileToUpload[]' class='form-control-file' id='fileToUpload'
                                    multiple='multiple'>
                            </div>

                            <br>

                            <div class='form-group'>
                                <button type='submit' class='btn btn-success' title='Spara'>Spara</button>
                            </div>
                        </form>

                        <br>

                    </div>
                    <!-- End add new note section -->

                    <p></p>

                    <?php
              echo getCurrentProjectNotes($row['pr_ID']);
            ?>

                </div>
            </div>
        </div>
    </div>

</div>

</div>





<?php
  }else {
    echo "<div class='alert alert-info'>Inga projekt hittades</div>";
  }
  ?>
<script>

    // enables the delete button on checked
    $('#enableCheck').click(function() {

        if ($(this).is(':checked')) {
            $('#btndelete').removeAttr('disabled');

        } else {
            $('#btndelete').attr('disabled', true);
        }
    });

    // enables form for notes
    $("#addnotesbutton").click(function() {
        $("#addnotesdiv").toggle("slow", function() {});
    });



    // cancel button listener
    $("#btn-avbryt").click(function(){
        $('#page-content').load('content/page_projekt.php');
    });
    
</script>