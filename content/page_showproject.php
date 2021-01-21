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
        <h4 class='mt-4'>Projekt: ". ucfirst($row["pr_name"]) ."</h4>
        <p class='mt-4'>Start: ". $row["pr_startdate"] ."</p>
        <br>
        
        
        
          <!-- Nav tabs -->
      <ul class='nav nav-tabs' id='inställningar-Tab' role='tablist'>      
         <li class='nav-item'>
            <a class='nav-link active' id='företag-tab' data-toggle='tab' href='#företag' role='tab' aria-controls='företag' aria-selected='true'>Information</a>
         </li>
         <li class='nav-item'>
            <a class='nav-link disabled' id='översikt-tab' data-toggle='tab' href='#översikt' role='tab' aria-controls='översikt' aria-selected='false'>Översikt</a>
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

            
            <div class='tab-pane' id='översikt' role='tabpanel' aria-labelledby='översikt-tab'>
                  

            <h4>Huvudmål</h4>
            <div class='table-responsive'>
            <table class='table table-striped table-hover table-m table-bordered table-projectlist'>
                <thead class='thead-dark'>                  
                  <tr class='text-center'>                      
                      <th scope='col'>Start/Möte</th>
                      <th scope='col'>Arbete</th>                                            
                      <th scope='col'>Avslut/Möte</th>
                      <th scope='col'>Fakturera</th>
                  </tr>
                  <tr class='text-center'>                      
                      <td scope='col'>Klart</td>
                      <td scope='col'>Pågående</td>                                            
                      <td scope='col'></td>
                      <td scope='col'></td>
                  </tr>
                </thead>
                <tbody id='projectResultList'>                  
                
              </tbody>
            </table>
           
          </div>


            
               </div>



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
    echo "Inga projekt hittades!";
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
</script>