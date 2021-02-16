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

  $sql2 = "SELECT *
            FROM tbl_status 
            ORDER BY tbl_status.st_ID ASC";
                       
  $result = mysqli_query($db,$sql);
  $result2 = mysqli_query($db,$sql2);
  
  // print error message if something happend
  if (!$result || !$result2) {
      printf('Error: %s\n', mysqli_error($db));        
      exit();
  }    

  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_array($result)){ 

  
echo "<!-- Show project -->
<section class='page-showproject'>
        <div class='container-fluid'>
        <h4 class='mt-4'>". ucfirst($row["pr_name"]) ."</h4>
        <p class='mt-4'>Start: ". $row["pr_startdate"] ."</p>";

        /*
        // show check in or check out button depending if user is checked in
        if (isUserCheckedIn($row['pr_ID'])) {
          echo"
          <form method='post'>
            <button class='btn btn-warning' id='checkoutbutton'><i class='fas fa-user-minus'></i> Checka ut</button>
            <input type='hidden' name='action' value='checkOut'>          
            <input type='hidden' name='projectID' value='".$row['pr_ID']."'>
          </form>";
        }else {
         echo"
          <form method='post'>
            <button class='btn btn-success' id='checkinbutton'><i class='fas fa-user-plus'></i> Checka in</button>
            <input type='hidden' name='action' value='checkIn'>          
            <input type='hidden' name='projectID' value='".$row['pr_ID']."'>
          </form>";
        }*/
        echo"
        <p></p>
        
        
        
          <!-- Nav tabs -->
      <ul class='nav nav-tabs' id='inställningar-Tab' role='tablist'>      
         <li class='nav-item'>
            <a class='nav-link active' id='företag-tab' data-toggle='tab' href='#företag' role='tab' aria-controls='företag' aria-selected='true'>Information</a>
         </li>
         
         <li class='nav-item'>
            <a class='nav-link' id='notes-tab' data-toggle='tab' href='#notes' role='tab' aria-controls='notes' aria-selected='false'>Inlägg</a>
         </li>

         <!--
         <li class='nav-item'>
            <a class='nav-link' id='användare-tab' data-toggle='tab' href='#användare' role='tab' aria-controls='användare' aria-selected='false'>Kund info</a>
         </li>
         <li class='nav-item'>
            <a class='nav-link' id='maskiner-tab' data-toggle='tab' href='#maskiner' role='tab' aria-controls='maskiner' aria-selected='false'>Arbetare</a>
         </li>
         <li class='nav-item'>
            <a class='nav-link' id='schema-tab' data-toggle='tab' href='#schema' role='tab' aria-controls='schema' aria-selected='false'>Maskiner</a>
         </li>
         <li class='nav-item'>
            <a class='nav-link' id='schema-tab' data-toggle='tab' href='#schema' role='tab' aria-controls='schema' aria-selected='false'>Rapporter</a>
         </li>
         -->
      </ul>

      

      <!-- Tab panes -->
      <div class='card' id='card-inställningar'>
         <div class='card-body'>
            <div class='tab-content'>

            <!-- Add new note div -->
            <div class='tab-pane' id='notes' role='tabpanel' aria-labelledby='notes-tab'>
              <button class='btn btn-primary' id='addnotesbutton'><i class='fa fa-plus-circle'></i> Nytt inlägg</button>
              <div id='addnotesdiv' style='display: none'>
                <p></p>
                <form method='post' enctype='multipart/form-data'>
                  <input type='hidden' name='action' value='addNotes'>
                  <input type='hidden' name='projectIDInput' value='".$row['pr_ID']."'>
                  <div class='form-group'>
                    <label for='notesTextarea'>Gör ett nytt inlägg och lägg till en bild.</label>
                    <textarea class='form-control' name='notesTextarea' id='notesTextarea' rows='5'></textarea>
                  </div> 
                                
                  <div class='form-group'>              
                    <label for='file'>Lägg till en eller flera bilder</label>
                    <input type='file' name='fileToUpload[]' class='form-control-file' id='fileToUpload' multiple='multiple'>
                  </div>

                  <div class='form-group'>
                    <button type='submit' class='btn btn-success' title='Spara'>Spara</button>
                  </div>                        
                </form>
              </div>

              <!-- Current notes-->
              <p></p>";
              
              getCurrentProjectNotes($row['pr_ID']);
              
            echo "</div>
                  

               <div class='tab-pane active' id='företag' role='tabpanel' aria-labelledby='företag-tab'>
                  <form method='post'>
                    <input type='hidden' name='action' value='updateProjectInfo'>
                    <input type='hidden' name='pr_ID' value='".$row["pr_ID"]."'>
                      <div class='form-group'>
                          <label for='projektnamnInput'>Projektnamn</label>
                          <input type='text' class='form-control' name='projektnamnInput' id='projektnamnInput' value='".$row["pr_name"]."'>                          
                      </div>

                      <div class='form-group'>
                        <label for='egetidInput'>Eget-ID</label>
                        <input type='text' class='form-control' name='egetidInput' id='egetidInput' value='".$row["pr_internID"]."'>
                      </div>
                      
                      <div class='form-group'>

                        <div class='row'>
                          <div class='col'>
                            <label for='startdatumInput'>Startdatum</label>
                            <input type='date' class='form-control' style='font-size:small;' name='startdatumInput' id='startdatumInput' value='".$row["pr_startdate"]."'>
                          </div>                          
                            
                          <div class='col'>
                            <label for='slutdatumInput'>Slutdatum</label>
                            <input type='date' class='form-control' style='font-size:small;' name='slutdatumInput' id='slutdatumInput' value='".$row["pr_enddate"]."'>
                          </div>
                        </div>                          
                      </div>

                      <div class='form-group'>
                          <div class='row'>
                              <div class='col'>
                                <label for='status'>Projektstatus:</label>
                                </div>
                                <div class='col'>
                                <select id='status' name='statusInput'>";
                                while($row2 = mysqli_fetch_array($result2)){
                                  if ($row2['st_ID'] == $row['pr_status']) {
                                    echo "<option selected style='background-color:#".$row2['st_hex'].";' value='".$row2['st_ID']."'>".$row2['st_name']."</option>";
                                  }else {
                                    echo "<option style='background-color:#".$row2['st_hex'].";' value='".$row2['st_ID']."'>".$row2['st_name']."</option>";  # code...
                                  }                        
                                };                     
                                echo "</select>
                              </div>
                          </div>
                      
                      
                        
                      
                      
                      
                      <div class='form-group'>
                          <label for='beskrivningTextarea'>Beskrivning</label>
                          <textarea class='form-control' name='beskrivningTextarea' id='beskrivningTextarea' rows='5'>".$row['pr_description']."</textarea>
                      </div>";

                      
                          if ($_SESSION['user_role'] == 2) {
                            echo "<div class='form-group'>

                              <div class='row'>
                                <div class='col'>
                                
                                <button type='submit' class='btn btn-success' title='Spara'>Spara</button>
                                </form>

                                </div>
                                <div class='col'>
                                
                                <form method='post'>
                                
                                  <input type='hidden' name='action' value='deleteProject'>
                                  <input type='hidden' name='removeThisProject' value='".$row["pr_ID"]."'>                                  
                                  <button type='submit' class='btn btn-danger' id='btndelete' title='Ta bort' disabled>Ta bort</button>                                  
                                  <div class='form-check'>
                                    <br>
                                    <input type='checkbox' class='form-check-input' id='enableCheck'>
                                    <label class='form-check-label' for='enableCheck'><p class='small'>Aktivera</p></label>
                                  </div>
                                </form>


                                </div>
                              </div>";
                          }

                        

                      echo "  
                      </div>
                
                 
                 
                
               </div>

        </div>";
      }
      echo "</section>";
  }else {
    echo "<div class='alert alert-info'>Inga projekt hittades!</div>";
  }
  ?>
<script>
  // enables the delete button on checked
  $('#enableCheck').click(function () {
        
    if ($(this).is(':checked')) {
      $('#btndelete').removeAttr('disabled');

    } else {
      $('#btndelete').attr('disabled', true);
    }
  });

  // enables form for notes
  $( "#addnotesbutton" ).click(function() {
    $( "#addnotesdiv" ).toggle( "slow", function() {      
  });
});
</script>