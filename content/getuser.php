<?php
require_once("../dbconnect.php");
session_start();

        $userID= intval($_GET['q']);
        
        global $db;
    
        $sql = "SELECT a.us_ID, a.us_username, a.us_password, a.us_fname, a.us_lname, a.us_email, a.us_phone1, a.us_phone2, a.us_roleID, a.us_isactive, a.us_created, b.ro_name
        FROM tbl_user a    
        LEFT JOIN tbl_role b ON b.ro_ID=a.us_roleID
        WHERE a.us_ID = $userID";
                             
        $result = mysqli_query($db,$sql);
        
        // print error message if something happend
        if (!$result) {
            printf("Error: %s\n", mysqli_error($db));        
            exit();
        }    
    
        if($result = $db->query($sql)){
    
            while($row = mysqli_fetch_array($result)) {                   
                echo "<div class='bg-warning p-2'>
                <fieldset class='border p-2'>
                   <legend  class='w-auto'>Inloggning</legend>
                   <div class='form-group'>
                        <input type='hidden' name='userID' value='" . $row["us_ID"]. "'>  
                      <label for='usernameInput'>Användarnamn</label> <div class='badge badge-pill badge-info' id='usernameInput-error'></div>
                      <input type='text' class='form-control' name='usernameInput' id='usernameInput' value='" . $row["us_username"]. "' onkeyup='validate(this)'>                        
                   </div>
                   <div class='form-group'>
                      <label for='pass1Input'>Lösenord</label> <div class='badge badge-pill badge-info' id='pass1Input-error'></div>
                      <input type='password' class='form-control' name='pass1Input' id='pass1Input' value='" . $row["us_password"]. "' onkeyup='validatePassword(this)'>
                      <br>
                      <label for='pass2Input'>Skriv lösenord igen</label>
                      <input type='password' class='form-control' name='pass2Input' id='pass2Input' value='" . $row["us_password"]. "' onkeyup='validatePassword(this)'>
                   </div>
                </fieldset>
             </div>
             <br>
                 
             <div class='form-group'>
                <div class='form-row'>
                   <div class='col'><label for='firstnameInput'>Förnamn</label>
                      <input type='text' class='form-control' name='firstnameInput' id='firstnameInput' value='" . $row["us_fname"]. "'>
                   </div>
                   <div class='col'><label for='lastnameInput'>Efternamn</label>
                      <input type='text' class='form-control' name='lastnameInput' id='lastnameInput' value='" . $row["us_lname"]. "'>
                   </div>
                </div>
             </div>
             <div class='form-group'>
                <div class='form-row'>
                   <div class='col'><label for='emailInput'>E-post</label>
                      <input type='text' class='form-control' name='emailInput' id='emailInput' placeholder='name@example.com' value='" . $row["us_email"]. "'>
                   </div>
                   <div class='col'></div>
                </div>
             </div>
             <div class='form-group'>
                <div class='form-row'>
                   <div class='col'><label for='phone1Input'>Telefon 1</label>
                      <input type='text' class='form-control' name='phone1Input' id='phone1Input' value='" . $row["us_phone1"]. "'>
                   </div>
                   <div class='col'><label for='phone2Input'>Telefon 2</label>
                      <input type='text' class='form-control' name='phone2Input' id='phone2Input' value='" . $row["us_phone2"]. "'>
                   </div>
                </div>
             </div>
    
    
             <div class='form-group'>
                <div class='form-row'>
                   <div class='col'>
                   
                   <legend class='col-form-label col-sm-2 pt-0'>Behörighet</legend>
                <div class='col-sm-10'>
                   <div class='form-check'>";                   
                   if ($row["us_roleID"] == 2 && $row["us_username"] == $_SESSION["login_user"]) {
                    echo "<input class='form-check-input' type='radio' name='roleRadios' id='roleRadios-admin' value='2' checked disabled>";
                   } else if($row["us_roleID"] == 2) {
                    echo "<input class='form-check-input' type='radio' name='roleRadios' id='roleRadios-admin' value='2' checked>";
                   }else {
                     echo "<input class='form-check-input' type='radio' name='roleRadios' id='roleRadios-admin' value='2'>";
                   }
                   echo "<label class='form-check-label' for='roleRadios'>
                      Admin
                      </label>
                   </div>
                   <div class='form-check'>";
                   if ($row["us_roleID"] == 2 && $row["us_username"] == $_SESSION["login_user"]) {
                    echo "<input class='form-check-input' type='radio' name='roleRadios' id='roleRadios-user' value='3' disabled>";
                   } else if($row["us_roleID"] == 3){
                    echo "<input class='form-check-input' type='radio' name='roleRadios' id='roleRadios-user' value='3' checked>";
                   }else {
                     echo "<input class='form-check-input' type='radio' name='roleRadios' id='roleRadios-user' value='3'>";
                   }
                   echo "<label class='form-check-label' for='roleRadios'>
                      User
                      </label>
                   </div>
                </div>
                        </div>
                <div class='form-group'>
                   </div>
                   <div class='col'>
    
                   <legend class='col-form-label col-sm-2 pt-0'>Status</legend>
                <div class='col-sm-10'>
                   <div class='form-check'>";
                                      
                   if ($row["us_roleID"] == 2 && $row["us_username"] == $_SESSION["login_user"]) {
                    echo "<input class='form-check-input' type='radio' name='statusRadios' id='statusRadios-active' value='1' checked disabled>";
                   } else if ($row["us_isactive"] == 1) {
                    echo "<input class='form-check-input' type='radio' name='statusRadios' id='statusRadios-active' value='1' checked>";
                   }else {
                     echo "<input class='form-check-input' type='radio' name='statusRadios' id='statusRadios-active' value='1'>";
                   }

                      echo "<label class='form-check-label' for='statusRadios'>
                      Aktiv
                      </label>
                   </div>
                   <div class='form-check'>";
                   
                   
                  if ($row["us_roleID"] == 2 && $row["us_username"] == $_SESSION["login_user"]) {
                    echo "<input class='form-check-input' type='radio' name='statusRadios' id='statusRadios-passive' value='0' disabled>";
                } else if ($row["us_isactive"] == 0) {
                    echo "<input class='form-check-input' type='radio' name='statusRadios' id='statusRadios-passive' value='0' checked>";
                } else {
                  echo "<input class='form-check-input' type='radio' name='statusRadios' id='statusRadios-passive' value='0'>";
                }

                      echo "<label class='form-check-label' for='statusRadios'>
                      Passiv
                      </label>
                   </div>
                </div>
    
                   </div>
                </div>
             </div>
             
    
    ";
    
    
    
                
              }
            
        }//end if
        
        // free sql result    
        mysqli_free_result($result);        
        
        // return result
        return $result;

        
                               
        // close connection
        $db-> close();
           

        
        
     
?>