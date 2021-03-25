<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "dbconnect.php";

// ------------------------------
// Call functions from post forms
// ------------------------------

if (isset($_POST['action'])) {

    /*echo "<pre>";
    echo var_dump($_POST);
    echo "</pre>";*/
    
    if ($_POST['action'] == 'updateUser') {
        updateUserInfo(); // call function
    }

    if ($_POST['action'] == 'updateUserProfile') {
        updateUserProfile(); // call function
    }
    
    if ($_POST['action'] == 'addUser') {
        addNewUser(); // call function
    }
    
    if ($_POST['action'] == 'deleteUser') {
        deleteUser(); // call function
    }
    
    if ($_POST['action'] == 'searchProjects') {
        //getAllProjects(); // call function
        echo "<script>alert('helloj search')</script>";
    }
    
    if ($_POST['action'] == 'reportTime') {
        reportTime(); // call function        
    }

    if ($_POST['action'] == 'updateTime') {
        updateTime(); // call function
    }

    if ($_POST['action'] == 'reportAbsence') {
        reportAbsence(); // call function        
    }

    if ($_POST['action'] == 'updateCompanyInfo') {        
        updateCompanyInfo(); // call function        
    }

    if ($_POST['action'] == 'deleteReport') {
        deleteReportDate(); // call function
    }

    if ($_POST['action'] == 'updateProjectInfo') {
        updateProjectInfo(); // call function
    }
    
    if ($_POST['action'] == 'newProject') {
        addNewProject(); // call function
    }

    if ($_POST['action'] == 'deleteProject') {
        deleteProject(); // call function
    }

    if ($_POST['action'] == 'addNotes') {
        addNotes(); // call function
    }

    if ($_POST['action'] == 'newMachine') {
        addNewMachine(); // call function
    }

    if ($_POST['action'] == 'editMachine') {
        updateMachine(); // call function
    }

    if ($_POST['action'] == 'deleteMachine') {
        deleteMachine(); // call function
    }

    if ($_POST['action'] == 'newVehicle') {
        addNewVehicle(); // call function
    }

    if ($_POST['action'] == 'editVehicle') {
        updateVehicle(); // call function
    }

    if ($_POST['action'] == 'deleteVehicle') {
        deleteVehicle(); // call function
    }

    if ($_POST['action'] == 'newTool') {
        addNewTool(); // call function
    }

    if ($_POST['action'] == 'editTool') {
        updateTool(); // call function
    }

    if ($_POST['action'] == 'deleteTool') {
        deleteTool(); // call function
    }

    if ($_POST['action'] == 'newMaterial') {
        addNewMaterial(); // call function
    }

    if ($_POST['action'] == 'editMaterial') {
        updateMaterial(); // call function
    }

    if ($_POST['action'] == 'deleteMaterial') {
        deleteMaterial(); // call function
    }

    if ($_POST['action'] == 'checkIn') {        
        checkIn(); // call function
    }

    if ($_POST['action'] == 'checkOut') {        
        checkOut(); // call function
    }

    if ($_POST['action'] == 'updatePersonalCard') {        
        updatePersonalCard(); // call function
    }

    if ($_POST['action'] == 'reportFuel') {        
        reportFuel(); // call function
    }

    if ($_POST['action'] == 'deleteFuel') {        
        deleteFuel(); // call function 
    }
        
}


// ------------------------------
// Functions
// ------------------------------

function addNewUser()
{
    // set global db variable from dbconnect
    global $db;

    $nameCheck = $_POST['usernameInput'];    
    
    // check if username i avaiable
    $sql = "SELECT *
            FROM
                tbl_user a            
            WHERE
                a.us_username = '$nameCheck'
            ";
    
    try {
        $result = mysqli_query($db, $sql);        
        $count = mysqli_num_rows($result);           

        // add user if username is free
        if ($count <1) {        
        
        // get company ID
        $company = $_SESSION['user_company_ID'];
        
        // prepare sql query and bind
        $stmt = $db->prepare("INSERT INTO tbl_user (                        
                                us_username,
                                us_password,
                                us_fname,
                                us_lname,
                                us_email,
                                us_phone1,
                                us_phone2,
                                us_roleID,
                                us_isactive)

                                VALUES (
                                    ?,?,?,?,?,?,?,?,?)
                                ");
    
        // get _POST form values and bind.
        // set parameters and execute
        $stmt->bind_param("sssssssii", $username, $pass, $firstname, $lastname, $email, $phone1, $phone2, $roles, $isactive);
        
        $username  = $_POST['usernameInput'];
        $pass      = $_POST['pass1Input'];
        $firstname = $_POST['firstnameInput'];
        $lastname  = $_POST['lastnameInput'];
        $email     = $_POST['emailInput'];
        $phone1    = $_POST['phone1Input'];
        $phone2    = $_POST['phone2Input'];
        $roles     = $_POST['roleRadios'];
        $isactive  = $_POST['userStatusRadios'];
        
        if ($stmt !== false) {
            $stmt->execute();
            $stmt->close();
            
            // get last added user from tbl_user
            $stmt2   = "SELECT MAX(us_ID) FROM tbl_user";
            $result2 = mysqli_query($db, $stmt2);
            
            // print error message if user is not in the database
            if (!$result2) {
                printf("Error: %s\n", mysqli_error($db));
                exit();
            }
            
            $row2  = mysqli_fetch_array($result2, MYSQLI_ASSOC);
            $count = mysqli_num_rows($result2);
            
            // if result matched add new user ID to table employees
            if ($count == 1) {
                $newUserID = $row2['MAX(us_ID)'];
                
                // prepare sql query and bind
                $stmt3 = $db->prepare("INSERT INTO tbl_employees (em_companyID, em_userID) VALUES (?,?)");
                
                // set parameters and execute
                $stmt3->bind_param("ii", $COMPANYID, $USERID);
                
                $COMPANYID = $company;
                $USERID    = $newUserID;
                
                if ($stmt3 !== false) {
                    $stmt3->execute();
                    $stmt3->close();
                    $db->close();
                    
                    echo "
                        <script src='vendor/jquery/jquery.min.js'></script>
                        <script>$(document).ready(function(){
                            alert('Ny användare inlagd');
                            $('#page-content').load('content/page_inställningar.php');
                        });
                        </script>
                    ";
                } else {
                    die('prepare() failed: ' . htmlspecialchars($db->error));
                }
            }
        } else {
            die('prepare() failed: ' . htmlspecialchars($db->error));
        }
            
            // DO not add user if username is not available
            } else if ($count >0) {
                
                
                echo "
                        <script src='vendor/jquery/jquery.min.js'></script>
                        <script>
                            alert('Det finns redan en användare med det här namnet, välj ett annat namn.');
                            $('#page-content').load('content/newproject.php');                                           
                        </script>
                    ";
                
            } else {
                die('prepare() failed: ' . htmlspecialchars($db->error));
            }
        
    } catch (\Throwable $th) {
        //throw $th;
        echo $th;
    }
    
}

// get all users
function getAllUsers()
{
    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT a.us_ID, a.us_username, a.us_isactive, a.us_roleID, c.ro_name
            FROM tbl_user a
            LEFT JOIN tbl_employees b ON b.em_userID=a.us_ID
            LEFT JOIN tbl_role c ON c.ro_ID=a.us_roleID
            WHERE b.em_companyID = $company
            ORDER BY a.us_username ASC";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr scope='row'>";
            echo "</td><td><a href='#' onclick='showUser(" . $row["us_ID"] . ")' aria-hidden='true' data-toggle='modal' data-target='#editUserModal' id='" . $row["us_ID"] . "'>" . ucfirst($row["us_username"]) . "</a></td>";
            echo "<td class='text-left d-none d-lg-table-cell'>" . ucfirst($row["ro_name"]) . "</td>";
            echo "<td class='text-left d-none d-lg-table-cell'>";
            if ($row["us_isactive"] == 1) {
                echo "<i class='fas fa-circle fa-xs text-success'></i> <span class='text-muted small'>Aktiv</span>";
            } else {
                echo "<i class='fas fa-circle fa-xs text-danger'></i> <span class='text-muted small'>Passiv</span>";
            }
            echo "</td>";
            
            echo "</td><td><a href='#' class='updateUserLink' onclick='showUser(" . $row["us_ID"] . ")' title='Redigera'><i class='fas fa-pencil-alt text-warning mr-4' aria-hidden='true' data-toggle='modal' data-target='#editUserModal'></i></a>";
            if ($row["us_username"] != $_SESSION['login_user']) {
                echo "<a href='#' class='deleteUserLink' title='Ta bort'><i class='fa fa-times-circle text-danger' aria-hidden='true' data-toggle='modal' data-target='#removeUserModal' data-user-id=" . $row["us_ID"] . " data-user-name=" . $row["us_username"] . "></i></a></td>";
            } else {
                echo "<i class='fa fa-times-circle text-muted' title='Spärrad, du kan inte ta bort dig själv'></i>";
            }
            
            
            echo "</tr>";
        }
    }
    
    // free sql result
    mysqli_free_result($result);
    
    // return result
    return $result;
    
    // close connection
    $db->close();
}

function deleteUser()
{
    // set global db variable from dbconnect
    global $db;
    
    $userID = $_POST['userID-data'];
    
    $stmt = $db->prepare("DELETE FROM tbl_user WHERE us_ID = ?");
    $stmt->bind_param('i', $userID);
    
    if ($stmt !== false) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        
        echo "  
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Användaren har tagits bort');
                    $('#page-content').load('content/page_inställningar.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
    
}

function updateUserInfo()
{
    
    // set global db variable from dbconnect
    global $db;
    
    // prepare sql query and bind
    $stmt = $db->prepare("UPDATE tbl_user
                            SET
                            us_username = ?,
                            us_password = ?,
                            us_fname = ?,
                            us_lname = ?,
                            us_email = ?,
                            us_phone1 =  ?,
                            us_phone2 = ?,
                            us_roleID = ?,
                            us_isactive = ?
                            WHERE
                            us_ID = ?");
    
    // get _POST form values and bind.
    // set parameters and execute
    $stmt->bind_param("sssssssiii", $username, $pass, $firstname, $lastname, $email, $phone1, $phone2, $roles, $isactive, $userID);
    
    $username  = $_POST['usernameInput'];
    $pass      = $_POST['pass1Input'];
    $firstname = $_POST['firstnameInput'];
    $lastname  = $_POST['lastnameInput'];
    $email     = $_POST['emailInput'];
    $phone1    = $_POST['phone1Input'];
    $phone2    = $_POST['phone2Input'];
    $roles     = $_POST['roleRadios'];
    $isactive  = $_POST['statusRadios'];
    $userID    = $_POST['userID'];
    
    if ($stmt !== false) {
        $stmt->execute();
        $db->close();
        $stmt->close();
        
        echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Uppdateringen genomförd');
                    $('#page-content').load('content/page_inställningar.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
}

function updateUserProfile(){

    // set global db variable from dbconnect
    global $db;
    
    $userID = $_SESSION['user_ID'];

    // prepare sql query and bind
    $stmt = $db->prepare("UPDATE tbl_user
                            SET
                            us_username = ?,
                            us_password = ?,
                            us_fname = ?,
                            us_lname = ?,
                            us_email = ?,
                            us_phone1 =  ?,
                            us_phone2 = ?
                           
                            WHERE
                            us_ID = $userID");
    
    // get _POST form values and bind.
    // set parameters and execute
    $stmt->bind_param("sssssss", $username, $pass, $firstname, $lastname, $email, $phone1, $phone2);
    
    $username  = $_POST['usernameInput'];
    $pass      = $_POST['pass1Input'];
    $firstname = $_POST['firstnameInput'];
    $lastname  = $_POST['lastnameInput'];
    $email     = $_POST['emailInput'];
    $phone1    = $_POST['phone1Input'];
    $phone2    = $_POST['phone2Input'];
    
    if ($stmt !== false) {
        $stmt->execute();
        $db->close();
        $stmt->close();
        
        echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Din profil är uppdaterad.');
                    $('#page-content').load('content/page_profile.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
}

function updateCompanyInfo()
{
    // set global db variable from dbconnect
    global $db;
            
    // prepare sql query and bind
    $stmt = $db->prepare("UPDATE tbl_company
                            SET
                            co_name = ?,
                            co_orgnbr = ?,
                            co_description = ?                             
                            WHERE
                            co_ID = ?");
    
    // get _POST form values and bind.
    // set parameters and execute
    $stmt->bind_param("sssi", $cname, $corgnbr, $cdesc, $companyID);
          
    $cname      = $_POST['företagsnamnInput'];
    $corgnbr    = $_POST['organisationsnummerInput'];
    $cdesc      = $_POST['beskrivningTextarea'];    
    $companyID  = $_SESSION['user_company_ID'];  
    
    if ($stmt !== false) {
        $stmt->execute();        
        
        echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Företagets information är uppdaterad');
                window.location.href = index.php
                });                        
            </script>
        ";

        // reload info
        reloadCompanyInfo();

    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
}

function reloadCompanyInfo() {

    // set global db variable from dbconnect
    global $db;

    $companyID = $_SESSION['user_company_ID'];    

    // get company info
    $sql = "SELECT *
            FROM
                tbl_company a            
            WHERE
                a.co_ID = $companyID";

    $result = mysqli_query($db,$sql);

    // print error message if user is not in the database
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));        
        exit();
    }
  
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);                        
    $count = mysqli_num_rows($result);
  
    // if result matched table row must be 1 row
    if($count == 1) {
        // session_register company info;
        $_SESSION['user_company_ID'] = $row['co_ID'];         
        $_SESSION['user_company'] = $row['co_name'];
        $_SESSION['user_company_nr'] = $row['co_orgnbr'];
        $_SESSION['user_company_desc'] = $row['co_description'];
        $_SESSION['user_company_start'] = $row['co_startdate'];
        $_SESSION['user_company_end'] = $row['co_enddate'];
        $_SESSION['user_company_isactive'] = $row['co_isactive'];               


    }else {
            die('error message: ' . htmlspecialchars($db->error));
        }

}

function updateProjectInfo(){
    // set global db variable from dbconnect
    global $db;
                
    // prepare sql query and bind
    $stmt = $db->prepare("UPDATE tbl_project
                            SET
                            pr_internID = ?,
                            pr_name = ?,
                            pr_description = ?,
                            pr_startdate = ?,
                            pr_enddate = ?,
                            pr_status = ?,
                            pr_billed = ?,
                            pr_billdate = ?,
                            pr_companyID = ?                             
                            WHERE
                            pr_ID = ?");

    // get _POST form values and bind.
    // set parameters and execute
    $stmt->bind_param("sssssiisii", $cintern, $cname, $cdesc, $cstartdate, $cenddate, $cstatus, $cbilled, $cbilldate, $ccompanyID, $cprojectID);
            
    $cintern        = $_POST['egetidInput'];
    $cname          = $_POST['projektnamnInput'];
    $cdesc          = $_POST['beskrivningTextarea'];    
    $cstartdate     = $_POST['startdatumInput'];      

    // check if end date is empty
    if ($_POST['slutdatumInput'] == "") {
        $cenddate       = NULL;
    }else {
        $cenddate       = $_POST['slutdatumInput'];
    }

    $cstatus        = $_POST['statusInput']; 
    $cbilled        = ""; 
    $cbilldate      = ""; 
    $ccompanyID     = $_SESSION['user_company_ID'];
    $cprojectID     = $_POST['pr_ID']; 

    if ($stmt !== false) {
        $stmt->execute();        
        $count=$stmt->affected_rows;
        echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Projektets information är uppdaterad');
                window.location.href = index.php
                });                        
            </script>
        ";

        
        $stmt->close();
        $db->close();
        return ($count>0);

    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
    
}

function addNotes(){
          
    // set global db variable from dbconnect
    global $db;
    
    // prepare sql query and bind
    $stmt = $db->prepare("INSERT INTO tbl_notes(
        no_created,
        no_content,
        no_userID,
        no_projectID
    )
    VALUES(NOW(), ?,?,?)");
    
    // get $_POST form values and bind.
    // set parameters and execute
    $stmt->bind_param("sii", $noteInput, $userID, $projectInput);
    
    $noteInput = mysqli_real_escape_string($db, $_POST['notesTextarea']);
    $userID = $_SESSION['user_ID'];
    $projectInput = $_POST['projectInput'];        


    if ($stmt !== false) {
        $stmt->execute();
        
        checkIfAnyFileUploaded();

        echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Ditt inlägg är sparat');
                $('#page-content').load('content/page_projekt.php');
            });
            </script>
        ";

        $stmt->close();
        $db->close();
        
    }else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
        if(!$stmt){
            echo "Error: " . mysqli_error($db);
            }
    }    
    
}

/**
 * check if any file uploaded
 */
function checkIfAnyFileUploaded(){

    $count = count($_FILES['fileToUpload']['name']);

    if($count>0){    
        
        for($j=0; $j < count($_FILES["fileToUpload"]['name']); $j++){ //loop the uploaded file array

            $theFile = $_FILES["fileToUpload"]['name']["$j"]; //file name
            
            // create a random name postfix and add it to file name                
            $postfix = date('YmdHis') . '_' . str_pad(rand(1,10000), 5, '0', STR_PAD_LEFT) . '_';

            // get rid of slashes and add postfix
            $theFilePostfix = $postfix . stripslashes($theFile);

            $path = 'uploads/'.$theFilePostfix; //generate the destination path


            if(move_uploaded_file($_FILES["fileToUpload"]['tmp_name']["$j"],$path)){ //upload the file                                

                // connect the image(s) to the latest work report
                global $db;
                $stmt   = "SELECT MAX(wo_ID) FROM tbl_workinghours";
                $result = mysqli_query($db, $stmt);
                $row  = mysqli_fetch_array($result, MYSQLI_ASSOC);           
                
                $woID = $row['MAX(wo_ID)']; // latest work ID
                $query = "insert into tbl_image(im_name, im_workID) values('".$theFilePostfix."','".$woID."')"; // insert into tbl_image

                // execute
                if (mysqli_query($db,$query)) {
                
                    echo"
                        <script src='vendor/jquery/jquery.min.js'></script>
                        <script>$(document).ready(function(){
                            alert('Filen# ".($j+1)." ($theFilePostfix) är sparad.');
                            $('#page-content').load('content/page_projekt.php');
                        })";                    
                
                } else {
                    echo"
                        <script src='vendor/jquery/jquery.min.js'></script>
                        <script>$(document).ready(function(){
                            alert('Filen# ".($j+1)." ($theFilePostfix) gick inte att spara på servern.');
                            $('#page-content').load('content/page_projekt.php');
                        })";                    
                }
            }
        }
    }
    else {        
        echo"
        <script src='vendor/jquery/jquery.min.js'></script>
        <script>$(document).ready(function(){
            alert('Inga filer hittades att ladda upp.');
            $('#page-content').load('content/page_projekt.php');
        })";    
    }
}

function addNewMachine(){

    // set global db variable from dbconnect
    global $db;        
          
    
    
  
        
    // prepare sql query and bind
    $stmt = $db->prepare("INSERT INTO tbl_machine (                        
                                        ma_name,
                                        ma_regnr,
                                        ma_mileage,
                                        ma_hours,
                                        ma_description,                
                                        ma_status,
                                        ma_owner)

                        VALUES (
                            ?,?,?,?,?,?,?)");
    
    // get _POST form values and bind.
    // set parameters and execute
                
    $stmt->bind_param("ssssssi", $cname, $creg, $cmile, $chours, $cdesc, $cstatus, $companyID);            
        
    $cname      = $_POST['machinenameInput'];
    $creg       = $_POST['regnrInput'];
    $cmile      = $_POST['mileageInput'];
    $chours     = $_POST['hoursInput'];
    $cdesc      = $_POST['descriptionInput'];
    $cstatus    = "1";
    $companyID  = $_SESSION['user_company_ID'];
    

    $stmt->execute();
    
    echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>
                alert('Ny maskin sparad.');
                $('#page-content').load('content/page_schema.php');                           
            </script>
        ";

    $stmt->close();
    $db->close();
        
}

function updateMachine(){

    // set global db variable from dbconnect
    global $db;

    $machineID  = $_POST['id'];
    
    // prepare sql query and bind
    $stmt = $db->prepare("UPDATE tbl_machine
                            SET
                            ma_name = ?,
                            ma_regnr = ?,
                            ma_mileage = ?,
                            ma_hours = ?,
                            ma_description = ?,
                            ma_status =  ?,
                            ma_owner = ?
                            WHERE
                            ma_ID = $machineID");
    
    // get _POST form values and bind.
    // set parameters and execute
    $stmt->bind_param("ssssssi", $name, $regnr, $mileage, $hours, $desc,  $status, $owner);
    
    $name       = $_POST['machinenameInput'];
    $regnr      = strtoupper($_POST['regnrInput']);
    $mileage    = $_POST['mileageInput'];
    $hours      = $_POST['hoursInput'];
    $desc       = $_POST['descriptionInput'];
    $status     = "1";
    $owner      = $_SESSION['user_company_ID'];
    
    if ($stmt !== false) {
        $stmt->execute();
        $db->close();
        $stmt->close();
        
        echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Uppdateringen genomförd.');
                    $('#page-content').load('content/page_equipment.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
}

function deleteMachine(){
    // set global db variable from dbconnect
    global $db;
        
    $machineID = $_POST['removeThisID'];

    $stmt = $db->prepare("DELETE FROM tbl_machine
                          WHERE ma_ID = ?");

    $stmt->bind_param('i', $machineID);

    if ($stmt !== false) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        
        echo "  
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Maskinen har tagits bort');
                    $('#page-content').load('content/page_equipment.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
}

function addNewVehicle(){

    // set global db variable from dbconnect
    global $db;        
            
    // prepare sql query and bind
    $stmt = $db->prepare("INSERT INTO tbl_vehicle (                        
                                        ve_name,
                                        ve_regnr,
                                        ve_mileage,
                                        ve_description,                
                                        ve_status,
                                        ve_owner)

                        VALUES (
                            ?,?,?,?,?,?)");

    // get _POST form values and bind.
    // set parameters and execute
                
    $stmt->bind_param("sssssi", $cname, $creg, $cmile, $cdesc, $cstatus, $companyID);            
        
    $cname      = $_POST['vehiclenameInput'];
    $creg       = $_POST['regnrInput'];
    $cmile      = $_POST['mileageInput'];
    $cdesc      = $_POST['descriptionInput'];
    $cstatus    = "1";
    $companyID  = $_SESSION['user_company_ID'];

    $stmt->execute();

    echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>
                alert('Nytt fordon sparad.');
                $('#page-content').load('content/page_schema.php');                           
            </script>
        ";

    $stmt->close();
    $db->close();
}

function updateVehicle(){

    // set global db variable from dbconnect
    global $db;

    $ID  = $_POST['id'];
    
    // prepare sql query and bind
    $stmt = $db->prepare("UPDATE tbl_vehicle
                            SET
                            ve_name = ?,
                            ve_regnr = ?,
                            ve_mileage = ?,
                            ve_description = ?,
                            ve_status =  ?,
                            ve_owner = ?
                            WHERE
                            ve_ID = $ID");
    
    // get _POST form values and bind.
    // set parameters and execute
    $stmt->bind_param("sssssi", $name, $regnr, $mileage, $desc,  $status, $owner);
    
    $name       = $_POST['vehiclenameInput'];
    $regnr      = strtoupper($_POST['regnrInput']);
    $mileage    = $_POST['mileageInput'];
    $desc       = $_POST['descriptionInput'];
    $status     = "1";
    $owner      = $_SESSION['user_company_ID'];
    
    if ($stmt !== false) {
        $stmt->execute();
        $db->close();
        $stmt->close();
        
        echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Uppdateringen genomförd.');
                    $('#page-content').load('content/page_equipment.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
}

function deleteVehicle(){
    // set global db variable from dbconnect
    global $db;
        
    $ID = $_POST['removeThisID'];

    $stmt = $db->prepare("DELETE FROM tbl_vehicle
                          WHERE ve_ID = ?");

    $stmt->bind_param('i', $ID);

    if ($stmt !== false) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        
        echo "  
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Fordonet har tagits bort');
                    $('#page-content').load('content/page_equipment.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
}

function addNewTool(){

    // set global db variable from dbconnect
    global $db;        
            
    // prepare sql query and bind
    $stmt = $db->prepare("INSERT INTO tbl_tools (                        
                                        to_name,
                                        to_description,  
                                        to_owner)

                        VALUES (
                            ?,?,?)");

    // get _POST form values and bind.
    // set parameters and execute
                
    $stmt->bind_param("ssi", $cname, $cdesc, $companyID);            
        
    $cname      = $_POST['toolnameInput'];
    $cdesc      = $_POST['descriptionInput'];
    $companyID  = $_SESSION['user_company_ID'];

    $stmt->execute();

    echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>
                alert('Nytt verktyg sparad.');
                $('#page-content').load('content/page_schema.php');                           
            </script>
        ";

    $stmt->close();
    $db->close();
}

function updateTool(){

    // set global db variable from dbconnect
    global $db;

    $ID  = $_POST['id'];
    
    // prepare sql query and bind
    $stmt = $db->prepare("UPDATE tbl_tools
                            SET
                            to_name = ?,
                            to_description = ?,
                            to_owner = ?
                            WHERE
                            to_ID = $ID");
    
    // get _POST form values and bind.
    // set parameters and execute
    $stmt->bind_param("ssi", $name, $desc,  $owner);
    
    $name       = $_POST['toolnameInput'];
    $desc       = $_POST['descriptionInput'];
    $owner      = $_SESSION['user_company_ID'];
    
    if ($stmt !== false) {
        $stmt->execute();
        $db->close();
        $stmt->close();
        
        echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Uppdateringen genomförd.');
                    $('#page-content').load('content/page_equipment.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
}

function deleteTool(){
    // set global db variable from dbconnect
    global $db;
        
    $ID = $_POST['removeThisID'];

    $stmt = $db->prepare("DELETE FROM tbl_tools
                          WHERE to_ID = ?");

    $stmt->bind_param('i', $ID);

    if ($stmt !== false) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        
        echo "  
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Verktyget har tagits bort');
                    $('#page-content').load('content/page_equipment.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
}

function deleteMaterial(){
    // set global db variable from dbconnect
    global $db;
        
    $ID = $_POST['removeThisID'];

    $stmt = $db->prepare("DELETE FROM tbl_materials
                          WHERE ma_ID = ?");

    $stmt->bind_param('i', $ID);

    if ($stmt !== false) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        
        echo "  
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Materielet har tagits bort');
                    $('#page-content').load('content/page_equipment.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
}

function addNewMaterial(){

    // set global db variable from dbconnect
    global $db;        
            
    // prepare sql query and bind
    $stmt = $db->prepare("INSERT INTO tbl_materials (                        
                                        ma_name,
                                        ma_description,  
                                        ma_owner)

                        VALUES (
                            ?,?,?)");

    // get _POST form values and bind.
    // set parameters and execute
                
    $stmt->bind_param("ssi", $cname, $cdesc, $companyID);            
        
    $cname      = $_POST['materialnameInput'];
    $cdesc      = $_POST['descriptionInput'];
    $companyID  = $_SESSION['user_company_ID'];

    $stmt->execute();

    echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>
                alert('Nytt materiel sparad.');
                $('#page-content').load('content/page_schema.php');                           
            </script>
        ";

    $stmt->close();
    $db->close();
}

function updateMaterial(){

    // set global db variable from dbconnect
    global $db;

    $ID  = $_POST['id'];
    
    // prepare sql query and bind
    $stmt = $db->prepare("UPDATE tbl_materials
                            SET
                            ma_name = ?,
                            ma_description = ?,
                            ma_owner = ?
                            WHERE
                            ma_ID = $ID");
    
    // get _POST form values and bind.
    // set parameters and execute
    $stmt->bind_param("ssi", $name, $desc,  $owner);
    
    $name       = $_POST['materialnameInput'];
    $desc       = $_POST['descriptionInput'];
    $owner      = $_SESSION['user_company_ID'];
    
    if ($stmt !== false) {
        $stmt->execute();
        $db->close();
        $stmt->close();
        
        echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Uppdateringen genomförd.');
                    $('#page-content').load('content/page_equipment.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
}

function addNewProject()
{   
    // set global db variable from dbconnect
    global $db;        
          
    $nameCheck = $_POST['projectNameInput'];    
    
    $sql = "SELECT *
            FROM
                tbl_project a            
            WHERE
                a.pr_name = '$nameCheck'         
            ";
            
    try {
        $result = mysqli_query($db, $sql);        
        $count = mysqli_num_rows($result);           

        if ($count <1) {        
        
            // prepare sql query and bind
            $stmt = $db->prepare("INSERT INTO tbl_project (                        
                pr_internID,
                pr_name,
                pr_description,
                pr_startdate,                
                pr_enddate,
                pr_companyID)
    
                VALUES (
                    ?,?,?,?,?,?)");
                
                // get _POST form values and bind.
                // set parameters and execute
                            
                $stmt->bind_param("sssssi", $cintern, $cname, $cdesc, $cstart, $cend, $companyID);            
                    
                $cintern    = $_POST['internInput'];
                $cname      = $_POST['projectNameInput'];
                $cdesc      = $_POST['descInput'];
                $cstart     = $_POST['startDateInput'];

                // check if end date is empty
                if ($_POST['endDateInput'] == "") {
                    $cend       = NULL;
                }else {
                    $cend       = $_POST['endDateInput'];
                }
                $companyID  = $_SESSION['user_company_ID'];
                                                
                $stmt->execute();
                
                echo "
                        <script src='vendor/jquery/jquery.min.js'></script>
                        <script>
                            alert('Projektet sparat');
                            $('#page-content').load('content/page_schema.php');                           
                        </script>
                    ";
    
                $stmt->close();
                $db->close();
            
            
        } else if ($count >0) {
            
            
            echo "
                    <script src='vendor/jquery/jquery.min.js'></script>
                    <script>
                        alert('Det finns redan ett projekt med det här namnet');                        
                        $('#page-content').load('content/newproject.php');                                           
                    </script>
                ";
            
        } else {
            die('prepare() failed: ' . htmlspecialchars($db->error));
        }
        
    } catch (\Throwable $th) {
        //throw $th;
        echo $th;
    }

    
}



function getAllMachines()
{
    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT *
            FROM tbl_machine a
            WHERE a.ma_owner = $company
            ORDER BY a.ma_name ASC";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<div class='card'>";
            echo "<div class='card-body'>";
            echo "<strong><a href='#' id='machine-link' maid='" . $row["ma_ID"] . "'>" . $row["ma_name"] . "</a></strong><br>";
            echo "Reg. nr. " . $row["ma_regnr"] ."<br><br>";       
            echo "</div>";
            echo "</div>";
            echo "<p></p>";
        }
    }else {
        echo "<div class='alert alert-secondary' role='alert'>Inga poster hittades.</div>";
    }
    
    // free sql result
    mysqli_free_result($result);
    
    // return result
    return $result;
    
    // close connection
    $db->close();
}

function getAllVehicles()
{
    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT *
            FROM tbl_vehicle a
            WHERE a.ve_owner = $company
            ORDER BY a.ve_name ASC";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<div class='card'>";
            echo "<div class='card-body'>";
            echo "<strong><a href='#' id='vehicle-link' maid='" . $row["ve_ID"] . "'>" . $row["ve_name"] . "</a></strong><br>";
            echo "Reg. nr. " . $row["ve_regnr"] ."<br><br>";               
            echo "</div>";
            echo "</div>";
            echo "<p></p>";
        }
    }else {
        echo "<div class='alert alert-secondary' role='alert'>Inga poster hittades.</div>";
    }
    
    // free sql result
    mysqli_free_result($result);
    
    // return result
    return $result;
    
    // close connection
    $db->close();
}

function getAllTools()
{
    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT *
            FROM tbl_tools a
            WHERE a.to_owner = $company
            ORDER BY a.to_name ASC";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<div class='card'>";
            echo "<div class='card-body'>";
            echo "<strong><a href='#' id='tool-link' maid='" . $row["to_ID"] . "'>" . $row["to_name"] . "</a></strong><br><br>";                        
            echo "</div>";
            echo "</div>";
            echo "<p></p>";
        }
    }else {
        echo "<div class='alert alert-secondary' role='alert'>Inga poster hittades.</div>";
    }
    
    // free sql result
    mysqli_free_result($result);
    
    // return result
    return $result;
    
    // close connection
    $db->close();
}

function getAllMaterials()
{
    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT *
            FROM tbl_materials a
            WHERE a.ma_owner = $company
            ORDER BY a.ma_name ASC";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<div class='card'>";
            echo "<div class='card-body'>";
            echo "<strong><a href='#' id='material-link' maid='" . $row["ma_ID"] . "'>" . $row["ma_name"] . "</a></strong><br><br>";                
            echo "</div>";
            echo "</div>";
            echo "<p></p>";
        }
    }else {
        echo "<div class='alert alert-secondary' role='alert'>Inga poster hittades.</div>";
    }
    
    // free sql result
    mysqli_free_result($result);
    
    // return result
    return $result;
    
    // close connection
    $db->close();
}

function getAllProjects()
{
    
    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT
                a.pr_ID,
                a.pr_internID,
                a.pr_name,
                a.pr_startdate,
                a.pr_enddate,
                b.st_hex,
                b.st_name
            FROM
                tbl_project a
            LEFT JOIN tbl_status b ON
                a.pr_status = b.st_ID
            WHERE
                a.pr_companyID = $company";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td scope='col' class='h5'><a href='http://' class='text-dark'>" . ucfirst($row["pr_name"]) . "</a></td>";
            echo "<td scope='col'>" . $row["pr_startdate"] . " -- " . $row["pr_enddate"] . "</td>";
            echo "<td scope='col' style='background-color: #" . $row["st_hex"] . ";' class='text-center'>" . $row["st_name"] . "</div></td>";
            echo "<td scope='col'></td>";
            echo "</tr>";
        }
        
    }
    return $result;
}

function getAllProjectsSelectList($cprojectID)
{
    
    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT
                a.pr_ID,
                a.pr_internID,
                a.pr_name            
            FROM
                tbl_project a            
            WHERE
                a.pr_companyID = $company
            ORDER BY a.pr_name ASC";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            if ($cprojectID) {
                if ($row['pr_ID'] == $cprojectID) {
                    echo "<option selected value='" . $row['pr_ID'] . "'>" . ucfirst($row["pr_name"]) . "</option>";
                } else {
                    echo "<option value='" . $row['pr_ID'] . "'>" . ucfirst($row["pr_name"]) . "</option>";
                }
                
            } else {
                echo "<option value='" . $row['pr_ID'] . "'>" . ucfirst($row["pr_name"]) . "</option>";
            }
            
        }
        
    }else {
        echo "<option selected value='0'>Ett projekt måste skapas först</option>";
    }    
    
}


function getAllMachinesSelectList()
{
    
    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT *   
            FROM
                tbl_machine a
            WHERE
                a.ma_owner = $company
            ORDER BY a.ma_name ASC";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<option value='" . ucfirst($row["ma_name"]) . " - " . $row["ma_regnr"] . "'>" . ucfirst($row["ma_name"]) . " - " . $row["ma_regnr"] . "</option>";            
        }
        
    }
    
}

function getAllVehiclesSelectList()
{
    
    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT *   
            FROM
                tbl_vehicle a
            WHERE
                a.ve_owner = $company
            ORDER BY a.ve_name ASC";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<option value='". ucfirst($row["ve_name"]) . " - " . $row["ve_regnr"] ."'>" . ucfirst($row["ve_name"]) . " - " . $row["ve_regnr"] . "</option>";            
        }
        
    }

}


function getAllAbscenceTypeSelectList()
{
    
    global $db;    
    
    $sql = "SELECT
                a.abt_ID,                
                a.abt_name
            FROM
                tbl_absencetype a                      
            ";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row['abt_ID'] . "'>" . ucfirst($row["abt_name"]) . "</option>";            
        }
        
    }
    
}

function getEmployeeSelectedList($cuserID){

    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT
            a.us_ID,
            a.us_username
            FROM
            tbl_user a
            LEFT JOIN tbl_employees ON tbl_employees.em_userID = a.us_ID
            WHERE
            tbl_employees.em_companyID = $company
            ORDER BY a.us_username ASC";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
        
    if ($count > 0) {                
        while ($row = mysqli_fetch_array($result)) {            
            if ($row['us_ID'] == $cuserID) {                    
                echo "<option selected value='" . $row['us_ID'] . "'>" . ucfirst($row["us_username"]) . "</option>";
            } else {
                echo "<option value='" . $row['us_ID'] . "'>" . ucfirst($row["us_username"]) . "</option>";    
            }                       
        }                            
        
    }else {
        echo "<option selected value='0'>Det finns inga användare</option>";
    }    

}



function reportTime()
{    

    // set global db variable from dbconnect
    global $db;        

    // prepare sql query and bind
    $stmt = $db->prepare("INSERT INTO tbl_workinghours (                        
        wo_userID,
        wo_date,
        wo_starttime,
        wo_endtime,
        wo_rest,        
        wo_total,        
        wo_notes,
        wo_projectID
        )

        VALUES (
            ?,?,?,?,?,?,?,?)");
        
        // get $_POST form values and bind.
        // set parameters and execute
                    
        $stmt->bind_param("issssssi", $userID, $date, $timefrom, $timeto, $break, $total, $notes, $projectID);            
            
        $userID    = $_SESSION['user_ID'];
        $date      = $_POST['datumInput'];
        $timefrom  = $_POST['timefromInput'];
        $timeto    = $_POST['timetoInput'];
        $break     = $_POST['breakInput'];
        $total     = $_POST['calcInput'];
        $notes     = $_POST['notesTextarea'];
        $projectID = $_POST['projectInput'];
        
        if ($stmt !== false) {
            $stmt->execute();
            
            checkIfAnyFileUploaded(); // check if there are any images and upload them
    
            echo "
                <script src='vendor/jquery/jquery.min.js'></script>
                <script>$(document).ready(function(){
                    alert('Ditt inlägg är sparat');
                    $('#page-content').load('content/page_schema.php');
                });
                </script>
            ";
    
            $stmt->close();
            $db->close();
            
        }else {
            die('prepare() failed: ' . htmlspecialchars($db->error));
            if(!$stmt){
                echo "Error: " . mysqli_error($db);
                }
        }
            
}

function updateTime(){

    $workedID = $_POST['workedID'];

    // set global db variable from dbconnect
    global $db;
    
    // prepare sql query and bind
    $stmt = $db->prepare("UPDATE tbl_workinghours
                            SET
                            wo_userID = ?,
                            wo_date = ?,
                            wo_starttime = ?,
                            wo_endtime = ?,
                            wo_rest = ?,
                            wo_total =  ?,
                            wo_notes = ?,
                            wo_projectID = ?
                            WHERE
                            wo_ID = $workedID");
    
    // get _POST form values and bind.
    // set parameters and execute
    $stmt->bind_param("issssssi", $userID, $date, $timefrom, $timeto, $break, $total, $notes, $projectID);
    
    $userID    = $_SESSION['user_ID'];
    $date      = $_POST['datumInput'];
    $timefrom  = $_POST['tidfrånInput'];
    $timeto    = $_POST['tidtillInput'];
    $break     = $_POST['rastInput'];
    $total     = $_POST['calcInput'];
    $notes     = $_POST['notesInput'];
    $projectID = $_POST['projektInput'];
    
    if ($stmt !== false) {
        $stmt->execute();
        $db->close();
        $stmt->close();
        
        echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Uppdateringen genomförd');
                    $('#page-content').load('content/page_myhours.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
}

function updateReportTime()
{    

    // set global db variable from dbconnect
    global $db;        

    $datecheck = $_POST['datumInput'];   
    $projectcheck = $_POST['projektInput'];       
    $userID = $_SESSION['user_ID'];
    
    $sql = "SELECT *
            FROM
                tbl_workinghours a            
            WHERE
                a.wo_date = '$datecheck'
            AND
                a.wo_userID = $userID
            AND
                a.wo_projectID = $projectcheck
            ";
            
    try {
        $result = mysqli_query($db, $sql);        
        $count = mysqli_num_rows($result);        

        if ($count <1) {        
        
            // prepare sql query and bind
            $stmt = $db->prepare("INSERT INTO tbl_workinghours (                        
                wo_userID,
                wo_date,
                wo_starttime,
                wo_endtime,
                wo_rest,
                wo_total,
                wo_notes,
                wo_projectID)
    
                VALUES (
                    ?,?,?,?,?,?,?,?)");
                
                // get _POST form values and bind.
                // set parameters and execute
                            
                $stmt->bind_param("issssssi", $userID, $date, $timefrom, $timeto, $break, $total, $notes, $projectID);            
                    
                $userID    = $_SESSION['user_ID'];
                $date      = $_POST['datumInput'];
                $timefrom  = $_POST['tidfrånInput'];
                $timeto    = $_POST['tidtillInput'];
                $break     = $_POST['rastInput'];
                $total     = $_POST['calcInput'];
                $notes     = $_POST['notesInput'];
                $projectID = $_POST['projektInput'];
                
                $stmt->execute();
                
                echo "
                        <script src='vendor/jquery/jquery.min.js'></script>
                        <script>
                            alert('Tidrapport inlagd');
                            $('#page-content').load('content/page_schema.php');                           
                        </script>
                    ";
    
                $stmt->close();
                $db->close();
            
            
        } else if ($count >0) {
            
            // prepare sql query and bind
            $stmt = $db->prepare("UPDATE tbl_workinghours
        SET
        wo_userID = ?,
        wo_date = ?,
        wo_starttime = ?,
        wo_endtime = ?,
        wo_rest = ?,
        wo_total = ?,
        wo_notes = ?,
        wo_projectID = ?
    
        WHERE
        wo_date = ?
        AND
        wo_userID = ?
        AND
        wo_projectID = ?
        ");
            
            // get _POST form values and bind.
            // set parameters and execute
            $stmt->bind_param("issssssisii", $userID, $date, $timefrom, $timeto, $break, $total, $notes, $projectID, $date, $userID, $projectID);
            
            $userID    = $_SESSION['user_ID'];
            $date      = $_POST['datumInput'];
            $timefrom  = $_POST['tidfrånInput'];
            $timeto    = $_POST['tidtillInput'];
            $break     = $_POST['rastInput'];
            $total     = $_POST['calcInput'];
            $notes     = $_POST['notesInput'];
            $projectID = $_POST['projektInput'];
            
            $stmt->execute();
                
                echo "
                        <script src='vendor/jquery/jquery.min.js'></script>
                        <script>
                            alert('Tidrapport uppdaterad');                        
                            $('#page-content').load('content/page_schema.php');                                             
                        </script>
                    ";
    
                $stmt->close();
                $db->close();
            
            
        } else {
            die('prepare() failed: ' . htmlspecialchars($db->error));
        }
        
    } catch (\Throwable $th) {
        //throw $th;
        echo $th;
    }

    
}

function deleteReportDate()
{
    // set global db variable from dbconnect
    global $db;  
    
    $userID = $_SESSION['user_ID'];
    $workedID   = $_POST['removeThisID'];
    
    $stmt = $db->prepare("DELETE
                            FROM
                                tbl_workinghours
                            WHERE
                                wo_userID   = ?
                            AND wo_ID     = ?");
    $stmt->bind_param('is', $userID, $workedID);
    
    if ($stmt !== false) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        
        echo "  
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Den rapporterade tiden har tagits bort');
                    $('#page-content').load('content/page_schema.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
    
}


function deleteProject()
{
    // set global db variable from dbconnect
    global $db;  
    
    $prID   = $_POST['removeThisProject'];
    
    $stmt = $db->prepare("DELETE
                            FROM
                                tbl_project
                            WHERE
                                pr_ID   = ?");
    $stmt->bind_param('i', $prID);
    
    if ($stmt !== false) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        
        echo "  
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Projektet har tagits bort');
                    $('#page-content').load('content/page_projekt.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
    
}


function reportAbsence()
{   
    // set global db variable from dbconnect
    global $db;        

    $datecheck = $_POST['datumfrånInput'];           
    $userID = $_SESSION['user_ID'];
    
    $sql = "SELECT *
            FROM
                tbl_absence a            
            WHERE
                a.ab_startdate = '$datecheck'
            AND
                a.ab_userID = $userID            
            ";
            
    try {
        $result = mysqli_query($db, $sql);        
        $count = mysqli_num_rows($result);           

        if ($count <1) {        
        
            // prepare sql query and bind
            $stmt = $db->prepare("INSERT INTO tbl_absence (                        
                ab_userID,
                ab_startdate,
                ab_enddate,
                ab_hours,
                ab_percent,                
                ab_notes,
                ab_type)
    
                VALUES (
                    ?,?,?,?,?,?,?)");
                
                // get _POST form values and bind.
                // set parameters and execute
                            
                $stmt->bind_param("isssssi", $userID, $startdate, $enddate, $hours, $percent, $notes, $type);            
                    
                $userID     = $_SESSION['user_ID'];
                $startdate  = $_POST['datumfrånInput'];
                $enddate    = $_POST['datumtillInput'];
                $hours      = $_POST['timmarInput'];
                $percent    = $_POST['procentInput'];
                $notes      = $_POST['notesInput'];
                $type       = $_POST['absenceTypeInput'];  
                                                
                $stmt->execute();
                
                echo "
                        <script src='vendor/jquery/jquery.min.js'></script>
                        <script>
                            alert('Frånvarorapport inlagd');
                            $('#page-content').load('content/page_schema.php');                           
                        </script>
                    ";
    
                $stmt->close();
                $db->close();
            
            
        } else if ($count >0) {
            
            // prepare sql query and bind
            $stmt = $db->prepare("UPDATE tbl_absence
            SET
            ab_userID = ?,
            ab_startdate = ?,
            ab_enddate  = ?,
            ab_hours = ?,
            ab_percent = ?,                
            ab_notes = ?,
            ab_type = ?
        
            WHERE
            ab_startdate = ?
            AND
            ab_userID = ?        
            ");
            
            // get _POST form values and bind.
            // set parameters and execute
            $stmt->bind_param("isssssisi", $userID, $startdate, $enddate, $hours, $percent, $notes, $type, $startdate, $userID);
            
            $userID    = $_SESSION['user_ID'];
            $startdate  = $_POST['datumfrånInput'];
            $enddate    = $_POST['datumtillInput'];
            $hours    = $_POST['timmarInput'];
            $percent     = $_POST['procentInput'];
            $notes     = $_POST['notesInput'];
            $type     = $_POST['absenceTypeInput'];                
            
            $stmt->execute();
                
                echo "
                        <script src='vendor/jquery/jquery.min.js'></script>
                        <script>
                            alert('Frånvarorapport uppdaterad');                        
                            $('#page-content').load('content/page_schema.php');                                             
                        </script>
                    ";
    
                $stmt->close();
                $db->close();
            
            
        } else {
            die('prepare() failed: ' . htmlspecialchars($db->error));
        }
        
    } catch (\Throwable $th) {
        //throw $th;
        echo $th;
    }

    
}

function getWorkWeek()
{
    
    $day        = date('w');
    $currentday = getCurrentDay();
    setWeekTotalHours(0);
    $workhourcounter = 0;
    
    for ($i = 1; $i < 6; $i++) {
        echo "
            <div class='col border-right schema-day-link time-panel-day-buttons' id='" . date('Y-m-d', strtotime('+' . ($i - $day) . ' days')) . "'>
                <span class='small font-weight-bold'>" . getWorkHoursForDate(date('Y-m-d', strtotime('+' . ($i - $day) . ' days'))) . "t</span><br>";
        // om datum är samma som dagens datum så markera med badgefärg
        if (date('d', strtotime('+' . ($i - $day) . ' days')) == $currentday) {
            echo "<span class='font-weight-normal text-lowercase text-nowrap'><div class='badge badge-pill bg-plana text-dark'>" . date('d', strtotime('+' . ($i - $day) . ' days')) . " " . getMonthName(date('m', strtotime('+' . ($i - $day) . ' days'))) . "</div></span><br>";
        } else {
            echo "<span class='font-weight-normal text-lowercase text-nowrap'>" . date('d', strtotime('+' . ($i - $day) . ' days')) . " " . getMonthName(date('m', strtotime('+' . ($i - $day) . ' days'))) . "</span><br>";
        }
        echo "<span class='small'>" . getDayName($i) . "</span>
            </div>";
        
        if (is_numeric(getWorkHoursForDate(date('Y-m-d', strtotime('+' . ($i - $day) . ' days'))))) {
            $workhourcounter += getWorkHoursForDate(date('Y-m-d', strtotime('+' . ($i - $day) . ' days')));
        } else {
            $workhourcounter += 0;
        }
        
        
    }
    setWeekTotalHours($workhourcounter);
    
}

function getWorkHours($cdate, $cprojectID){
    global $db;
    
    $date = $cdate;    
    $projectID = $cprojectID;        
    $userID = $_SESSION['user_ID'];
    
    $sql = "SELECT
                a.wo_date,
                a.wo_starttime,
                a.wo_endtime,
                a.wo_rest,
                a.wo_notes,
                a.wo_projectID          
            FROM
                tbl_workinghours a            
            WHERE
                a.wo_userID = $userID
            AND
                a.wo_date = '$date'
            AND a.wo_projectID = $projectID
            ";
    
    $result = mysqli_query($db, $sql);

    try {
        $result = mysqli_query($db, $sql);
        
    } catch (\Throwable $th) {
        //throw $th;
        echo $th;
    }
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
        return FALSE;
    }else {
        return mysqli_fetch_array($result);        
    }
    
}

function getWorkHoursForDate($cdate)
{
    
    global $db;
    
    $date = $cdate;

    if (isset($_SESSION['user_ID'])) {
        $userID = $_SESSION['user_ID'];
    } else {
        echo "<meta http-equiv='refresh' content='0;url=login.php'>";
        exit();
    }
    
    
        $sql = "SELECT
                    a.wo_total          
                FROM
                    tbl_workinghours a            
                WHERE
                    a.wo_userID = $userID
                AND
                    a.wo_date = '$date'
                ";
        
        $result = mysqli_query($db, $sql);
        
        // print error message if something happend
        if (!$result) {
            printf("Error: %s\n", mysqli_error($db));
            exit();
        }
        
        $count = mysqli_num_rows($result);    
        
        // if a date was found split wo_total time like 08:00 to 08 and 00
        // remove first 0 and return only 8 to time panel
        // if wo_total time is 00:00 return only 0 to time panel
        global $calchours;
        global $calcminutes;
        $calchours = 0;
        $calcminutes = 0;
        if ($count > 0) {
            while ($row = mysqli_fetch_array($result)) {

                $str     = $row['wo_total'];            
                $str_exp = (explode(':', $str));                    
                
                // calc hours
                if ($str_exp[0][0] == 0 AND $str_exp[0][1] !=0) {
                    $calchours += str_replace('0', '', $str_exp[0]);                                                                                             

                } elseif ($str_exp[0][0] == 0 AND $str_exp[0][1] == 0) {                
                    $calchours += $str_exp[0][1];                                      

                }else {                
                    $calchours += $str_exp[0];                                                            

                }
                
                //calc minutes
                if ($str_exp[1][0] == 0 AND $str_exp[1][1] !=0) {
                    $calcminutes += str_replace('0', '', $str_exp[1]);                                                                                             

                } elseif ($str_exp[1][0] == 0 AND $str_exp[1][1] == 0) {                
                    $calcminutes += $str_exp[1][1];                                      

                }else {                
                    $calcminutes += $str_exp[1];                                                            

                }

                // if minutes are more then or equal 60 add +1 calchours
                if (($calcminutes / 60)  >=1) {
                    $calchours += bcdiv(($calcminutes / 60), 1, 0);
                }            
                
            }
            // return $calchours;                
            return $calchours;
            
        } else {
            return 0;
        }

   
}

function getWorkHoursForMonth($cuserID, $cmonth, $cyear)
{
    
    global $db;        
            
    $sql = "SELECT
                a.wo_total          
            FROM
                tbl_workinghours a            
            WHERE
                a.wo_userID = $cuserID
            AND                
                MONTH(a.wo_date) = $cmonth
            AND
                YEAR(a.wo_date) = $cyear
            ";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);    
    
    // if a date was found split wo_total time like 08:00 to 08 and 00
    // remove first 0 and return only 8 to time panel
    // if wo_total time is 00:00 return only 0 to time panel
    global $calchours;
    global $calcminutes;
    $calchours = 0;
    $calcminutes = 0;
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {

            $str     = $row['wo_total'];            
            $str_exp = (explode(':', $str));                    
            
            // calc hours
            if ($str_exp[0][0] == 0 AND $str_exp[0][1] !=0) {
                $calchours += str_replace('0', '', $str_exp[0]);                                                                                             

            } elseif ($str_exp[0][0] == 0 AND $str_exp[0][1] == 0) {                
                $calchours += $str_exp[0][1];                                      

            }else {                
                $calchours += $str_exp[0];                                                            

            }            
            
            //calc minutes
            if ($str_exp[1][0] == 0 AND $str_exp[1][1] !=0) {
                $calcminutes += str_replace('0', '', $str_exp[1]);                                                                                             

            } elseif ($str_exp[1][0] == 0 AND $str_exp[1][1] == 0) {                
                $calcminutes += $str_exp[1][1];                                      

            }else {                
                $calcminutes += $str_exp[1];                                                            

            }            

            // if minutes are more then or equal 60 add +1 calchours
            // and remove 60 minutes from calcminutes
            if (($calcminutes / 60)  >=1) {
                $calchours += bcdiv(($calcminutes / 60), 1, 0);
                $calcminutes -= 60;                         
            }   
                        
            // add 00 if minutes are 0 to look prettier
            if ($calcminutes == 0)  {                                
                $str_calc = $calchours .':00';        
            }else {                      
                $str_calc = $calchours .':'. $calcminutes;
            }
                                      
        }   
        // return hours and minutes        
        return $str_calc;     
        
    } else {
        return 0;

    }
    
}

function getWorkedHours($cdate)
{
    
    global $db;
    
    $date = $cdate;
    
    $userID = $_SESSION['user_ID'];
    
    $sql = "SELECT *   
            FROM
                tbl_workinghours a        
            WHERE
                a.wo_userID = $userID
            AND
                a.wo_date = '$date'
            ";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);    
  
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<td class='align-middle'>".$row["wo_starttime"]."</td>
            <td class='align-middle'>".$row["wo_endtime"]."</td>
            <td class='align-middle'>".$row["wo_rest"]."</td>
            <td class='align-middle'>".$row["wo_total"]."</td>";
        }

    }else {
        echo "</td><td></td>";
        echo "</td><td></td>";
        echo "</td><td></td>";
        echo "</td><td></td>";

    }

}

function getWorkedHoursForReport($cuserID, $cyear, $cmonth, $disableNotesLink)
{        
    global $db;
                    
    $sql = "SELECT
                *
            FROM
                tbl_workinghours a
            LEFT JOIN tbl_project b ON
                b.pr_ID = a.wo_projectID             
            WHERE
                a.wo_userID = $cuserID                
                AND YEAR(a.wo_date) = $cyear
                AND MONTH(a.wo_date) = $cmonth                
                ORDER BY a.wo_date ASC
            ";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);    
  
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "   
            <tr id='".$row["wo_ID"]."' class='workedHoursDiv'>
                </td><td>".$row["wo_date"]."
                <br>
                <div class='ml-1 small'>".ucfirst($row["pr_name"])."</div>";
                
                    if (checkUserNotesAtDateForTimeReport($row["pr_ID"], $cuserID, $row["wo_date"]) == true && $_SESSION['user_role'] == 2 && $disableNotesLink == false) {
                        echo "<div class='ml-1 small'><a title='Visa notering' id='".$row['wo_ID']."' href='#".$row['wo_ID']."'><i class='fas fa-comment-alt'></i> Visa</a></div>";
                    }                  
            echo "
                </td>
                <td class='text-center'>".$row["wo_starttime"]."</td>
                <td class='text-center'>".$row["wo_endtime"]."</td>
                <td class='text-center'>".$row["wo_rest"]."</td>
                <td class='text-center'>".getCalcHours($row["wo_starttime"], $row["wo_endtime"], $row["wo_rest"])."</td>
            </tr>";

            echo getUserNotesAtDateForTimereport($row["pr_ID"], $cuserID, $row["wo_date"], $row['wo_ID']);
            
            // add total to global month hours
            setMonthTotalHours(getCalcHours($row["wo_starttime"], $row["wo_endtime"], $row["wo_rest"]));
        }

    }

}

function getAbsenceHoursForReport($cuserID, $cyear, $cmonth, $disableNotesLink)
{        
    global $db;
                    
    $sql = "SELECT
                *
            FROM
                tbl_absence a
            LEFT JOIN tbl_absencetype b ON
                b.abt_ID = a.ab_type
            WHERE
                a.ab_userID = $cuserID                
                AND YEAR(a.ab_startdate) = $cyear
                AND MONTH(a.ab_enddate) = $cmonth                
                ORDER BY a.ab_startdate ASC
            ";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);    
  
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "   
            <tr id='".$row["ab_ID"]."' class='absenceDiv'>
                </td><td>".ucfirst($row["abt_name"])."
                <br>";
                
                    if (checkUserNotesAtDateForAbsenceReport($row["ab_ID"], $cuserID, $row["ab_startdate"]) == true && $_SESSION['user_role'] == 2 && $disableNotesLink == false) {
                        echo "<div class='ml-1 small'><a title='Visa notering' id='".$row['ab_ID']."' href='#".$row['ab_ID']."'><i class='fas fa-comment-alt'></i> Visa</a></div>";
                    }                  
            echo "
                </td>
                <td class='text-center'>".$row["ab_startdate"]."</td>
                <td class='text-center'>".$row["ab_enddate"]."</td>
                <td class='text-center'>".$row["ab_hours"]."</td>
                <td class='text-center'>".$row["ab_percent"]."</td>
            </tr>";

            echo getUserNotesAtDateForAbsence($row["ab_ID"], $cuserID, $row["ab_startdate"], $row['ab_ID']);
            
        }

    }else{
        echo "<tr><td colspan='5'>Ingen frånvaro</td></tr>";        
    }

}

function getCalcHours($starttime, $endtime, $resttime){

    $secsInAnHour = 3600;
    $minsInAnHour = 60;
    $hoursInADay = 24;
    $decimalPlaces = 2;

    // split starttime in hours and minutes
    $starthour = substr($starttime, 0, 2);
    $startminute = substr($starttime, 3, 2);    

    // split endtime in hours and minutes
    $endhour = substr($endtime, 0, 2);
    $endminute = substr($endtime, 3, 2);

    // split resttime in hours and minutes
    $resthour = substr($resttime, 0, 2);
    $restminute = substr($resttime, 3, 2);

    // remove break time from hours and minutes if there is any
    if ($resthour >0) {
        $starthour = $starthour + $resthour;        
    }

    if ($restminute >0) {        
        $startminute = $startminute + $restminute;
    }

    $date1 = new DateTime();
    $date2 = new DateTime();
    $date1->setTime($starthour, $startminute);
    $date2->setTime($endhour, $endminute);

    $diff = $date2->diff($date1);

    $convertToHours = $diff->s / $secsInAnHour + $diff->i / $minsInAnHour + $diff->h + $diff->days * $hoursInADay;


    $hours = round($convertToHours, $decimalPlaces);
    
    return $hours;
}

function getFuelReports()
{        
    global $db;
    
    $companyID = $_SESSION['user_company_ID'];
    
    $sql = "SELECT
                *
            FROM
                tbl_fuel a            
            WHERE
                a.fu_companyID = $companyID
            ORDER BY a.fu_date DESC
            ";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);    
  
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "            
            <tr id='".$row["fu_ID"]."' class='small'>            
            <th scope='row'>".date('Y-m-d H:i',strtotime($row["fu_date"]))."<form method='post'><input type='hidden' name='action' value='deleteFuel'><input type='hidden' name='removeThisID' value='".$row["fu_ID"]."'> <button type='submit' class='btn btn-sm' style='padding:0;' title='Ta bort tankning'><i class='fa fa-times-circle text-danger'></i></button></form></th>
                </td><td>".$row["fu_name"]."</td>
                <td class='text-right'>".$row["fu_fuel"]."</td>
                <td class='text-right'>".$row["fu_adblue"]."</td>
                <td class='d-none d-lg-table-cell text-right'>".$row["fu_mileage"]."</td>
                <td class='d-none d-lg-table-cell text-right'>".$row["fu_hours"]."</td>
                <td class='d-none d-lg-table-cell'>".$row["fu_notes"]."</td>            
            </tr>";                        
        }

    }

}

function getUserFullName($cuserID){

    global $db;
            
    $sql = "SELECT            
            a.us_fname,
            a.us_lname,
            a.us_username
            FROM
            tbl_user a            
            WHERE
            a.us_ID = $cuserID
            ";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
        
    if ($count > 0) {                
        while ($row = mysqli_fetch_array($result)) {

            $first = ucfirst($row["us_fname"]);
            $last = ucfirst($row["us_lname"]);
            $user = ucfirst($row["us_username"]);

            if ($first || $last) {
                echo $first, " ", $last;
            } else {
                echo "<div class='small text-danger'>" . $user . " - Fullt namn saknas</div>";
            }                                                
        }                            
        
    }else {
        return null;
    }    

}

function getCurrentProjectNotes($cprojectID){

    global $db;
            
    // get notes and user info
    $sql = "SELECT *
            FROM
            tbl_notes a
            LEFT JOIN tbl_user b ON
                a.no_userID = b.us_ID              
            WHERE
                a.no_projectID = $cprojectID
            ORDER BY a.no_created DESC
            ";

    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
        
    if ($count > 0) {                
        while ($row = mysqli_fetch_array($result)) {
            echo "<div class='border p-3' style='background-color:#eee;'>";
            echo "  <div class='row'>
                        <div class='col'>
                            <p class='small'>" . ucfirst($row["us_username"]) . "<span class='text-muted'> - " . date('Y-m-d H:i',strtotime($row["no_created"])) . "</span></p>
                        </div>
                    </div>";
            echo "<div class='row'>";
                        getCurrentProjectNotesImages($row['no_ID']);
            echo "</div>";

            echo "<p></p>";

               
            echo "
                <div class='row'>
                    <div class='col'>
                        <p> " . ucfirst($row["no_content"]) . "</p>
                    </div>
                </div>";
            echo "</div><p></p>";
        }            
        
    }else {
        echo "Inga inlägg hittades";
    }
    
}

function getUserNotesAtDateForTimereport($cprojectID, $cuserID, $cdate){

    global $db;
            
    // get notes and user info
    $sql = "SELECT *
            FROM
            tbl_workinghours a
            LEFT JOIN tbl_user b
            ON a.wo_userID = b.us_ID
            WHERE
                a.wo_projectID = $cprojectID
                AND a.wo_userID = $cuserID
                AND DATE(a.wo_date) = '$cdate'
            ORDER BY a.wo_date DESC
            ";

    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
        
    if ($count > 0) {                
        while ($row = mysqli_fetch_array($result)) {
            
            echo "<tr id='".$row['wo_ID']."hour'>";
            echo "<td colspan='5' class='notescontent'>";
            echo "<div class='border p-3' style='background-color:#eee;'>";
            echo "  <div class='row'>
                        <div class='col'>
                            <p class='small'>" . ucfirst($row["us_username"]) . "<span class='text-muted'> - " . $row["wo_date"] . " -- ".$row["wo_starttime"]."</span></p>
                        </div>
                    </div>";
            echo "<div class='row'>";
                        getCurrentProjectNotesImages($row['wo_ID']);
            echo "</div>";

            echo "<p></p>";
               
            echo "
                <div class='row'>
                    <div class='col'>
                        <p> " . ucfirst($row["wo_notes"]) . "</p>
                    </div>
                </div>";
            echo "</div><p></p>";
            echo "</td>";
            echo "</tr>";
            
        }             
        
    }else {
        return false;
    }
    
}

function getUserNotesAtDateForAbsence($abID, $cuserID, $cdate){

    global $db;
            
    // get notes and user info
    $sql = "SELECT *
            FROM
            tbl_absence a
            LEFT JOIN tbl_user b
            ON a.ab_userID = b.us_ID
            WHERE
                a.ab_ID = $abID
                AND a.ab_userID = $cuserID
                AND DATE(a.ab_startdate) = '$cdate'
            ORDER BY a.ab_startdate DESC
            ";

    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
        
    if ($count > 0) {                
        while ($row = mysqli_fetch_array($result)) {
            
            echo "<tr id='".$row['ab_ID']."absc'>";
            echo "<td colspan='5' class='notescontent'>";
            echo "<div class='border p-3' style='background-color:#eee;'>";
            echo "  <div class='row'>
                        <div class='col'>
                            <p class='small'>" . ucfirst($row["us_username"]) . "<span class='text-muted'> - " . $row["ab_startdate"] . " -- ".$row["ab_enddate"]."</span></p>
                        </div>
                    </div>";
            echo "<div class='row'>";
                        
            echo "</div>";

            echo "<p></p>";
               
            echo "
                <div class='row'>
                    <div class='col'>
                        <p> " . ucfirst($row["ab_notes"]) . "</p>
                    </div>
                </div>";
            echo "</div><p></p>";
            echo "</td>";
            echo "</tr>";
            
        }             
        
    }else {
        return false;
    }
    
}

function checkUserNotesAtDateForTimeReport($cprojectID, $cuserID, $cdate){

    global $db;
            
    // get notes and user info
    $sql = "SELECT wo_notes
            FROM
            tbl_workinghours a                    
            WHERE
                a.wo_projectID = $cprojectID
                AND a.wo_userID = $cuserID
                AND DATE(a.wo_date) = '$cdate'
            ";

    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
        
    if ($count > 0 && $row['wo_notes'] !=NULL) {  
        return true;            
    }else {
        return false;
    }
    
}

function checkUserNotesAtDateForAbsenceReport($cprojectID, $cuserID, $cdate){

    global $db;
            
    // get notes and user info
    $sql = "SELECT ab_notes
            FROM
            tbl_absence a                    
            WHERE                
                a.ab_userID = $cuserID
                AND DATE(a.ab_startdate) = '$cdate'
            ";

    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
        
    if ($count > 0 && $row['ab_notes'] !=NULL) {  
        return true;            
    }else {
        return false;
    }
    
}

/**
 * get all images that belong to note ID
 */
function getCurrentProjectNotesImages($woID){

    global $db;
            
    // get notes and user info
    $sql = "SELECT *
            FROM
            tbl_image a            
            WHERE
            a.im_workID = $woID
            ";

    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
        
    if ($count > 0) {                
        while ($row = mysqli_fetch_array($result)) {           

            echo "<div class='col-lg-2 col-md-6 col-xs-12'>
            
                    <img class='img-thumbnail img-fluid' src='uploads/" . $row["im_name"] . "' alt='Inlägg bild'>
                
            </div>";
        }                            
        
    }
    
}

// check in user on project
function checkIn(){

    // set global db variable from dbconnect
    global $db;
    
    // prepare sql query and bind
    $stmt = $db->prepare("INSERT INTO tbl_checkin(
        ch_projectID,
        ch_userID,
        ch_time      
    )
    VALUES(?,?,NOW())");
    
    // get $_POST form values and bind.
    // set parameters and execute
    $stmt->bind_param("ii", $projectID, $userID);
        
    $projectID = $_POST['projectID'];  
    $userID = $_SESSION['user_ID'];        

    if ($stmt !== false) {
        $stmt->execute();
        echo "<script>alert('Du är nu incheckad på projektet.')</script>";
        
    }else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
        if(!$stmt){
            echo "Error: " . mysqli_error($db);
            }
    }
    $stmt->close();
}

// check out user on project
function checkOut(){

    // set global db variable from dbconnect
    global $db;
    
    $projectID = $_POST['projectID'];  
    $userID = $_SESSION['user_ID'];        
    
    $stmt = $db->prepare("DELETE FROM tbl_checkin WHERE ch_userID = ? AND ch_projectID = ?");
    $stmt->bind_param('ii', $userID, $projectID);
    
    if ($stmt !== false) {
        $stmt->execute();
        echo "<script>alert('Du har checkat ut från projektet.')</script>";
        
    }else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
        if(!$stmt){
            echo "Error: " . mysqli_error($db);
            }
    }
    $stmt->close();
}

// is user checked in on a project
function isUserCheckedIn($projectID){

    // set global db variable from dbconnect
    global $db;
    
    $userID = $_SESSION['user_ID'];        

    // check if username i avaiLable
    $sql = "SELECT *
            FROM
                tbl_checkin a            
            WHERE
                a.ch_projectID = $projectID
            AND a.ch_userID = $userID
            ";

    try {
        $result = mysqli_query($db, $sql);        
        $count = mysqli_num_rows($result);           

        // if there is a match return true
        if ($count >0){
            return true;
        }else {
            return false;
        }
        
        
    } catch (\Throwable $th) {
        //throw $th;
        echo $th;
    }
}

function getCheckedInUsers(){

    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT
                *
            FROM
                tbl_checkin a
            LEFT JOIN tbl_project b ON
                a.ch_projectID = b.pr_ID
            WHERE
                b.pr_companyID = $company";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<th scope='row'>" . $row["pr_name"] . "</th>";
            echo "</td><td>";
                getUserFullName($row["ch_userID"]);
            echo "</td>";
            echo "</td><td>". date('Y-m-d H:i', strtotime($row["ch_time"])) . "</td>";
            echo "</td><td><button class='btn btn-warning btn-sm' id='checkoutbutton' title='Checka ut'><i class='fas fa-user-minus'></i></button></td>";
            echo "</tr>";
        }
        
    }
    return $result;

}

function updatePersonalCard()
{
    $userID     = $_POST['userID'];
    
    // set global db variable from dbconnect
    global $db;
    
    // prepare sql query and bind
    $stmt = $db->prepare("UPDATE tbl_user
                            SET
                            us_employeenr = ?,
                            us_pnr = ?,
                            us_fname = ?,
                            us_lname = ?,
                            us_infotext = ?,
                            us_address1 = ?,
                            us_address2 = ?,
                            us_zip = ?,
                            us_city = ?,
                            us_email = ?,
                            us_phone1 =  ?,
                            us_phone2 = ?,
                            us_clearingnr = ?,
                            us_accountnr = ?
                            WHERE
                            us_ID = $userID");
    
    // get _POST form values and bind.
    // set parameters and execute
    $stmt->bind_param("ssssssssssssss", $employeenr, $pnr, $firstname, $lastname, $infotext, $address1, $address2, $zip, $city, $email, $phone1, $phone2, $clearingnr, $accountnr);
    
    $employeenr = $_POST['inputAnst-ID'];
    $pnr        = $_POST['inputPnr'];
    $firstname  = $_POST['inputFname'];
    $lastname   = $_POST['inputLname'];
    $infotext   = $_POST['inputInfotext'];
    $address1   = $_POST['inputAddress1'];
    $address2   = $_POST['inputAddress2'];
    $zip        = $_POST['inputZip'];
    $city       = $_POST['inputCity']; 
    $email      = $_POST['inputEmail'];
    $phone1     = $_POST['inputPhone1'];
    $phone2     = $_POST['inputPhone2'];
    $clearingnr = $_POST['inputClearnr'];
    $accountnr  = $_POST['inputAccountnr'];
    
    if ($stmt !== false) {
        $stmt->execute();
        $db->close();
        $stmt->close();
        
        echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Uppdateringen genomförd');
                    $('#page-content').load('content/page_staff.php');                      
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
}


function reportFuel()
{    

    // set global db variable from dbconnect
    global $db;        

    // prepare sql query and bind
    $stmt = $db->prepare("INSERT INTO tbl_fuel (                        
        fu_name,
        fu_date,
        fu_fuel,
        fu_adblue,
        fu_mileage,
        fu_hours,
        fu_notes,
        fu_companyID   
        )

        VALUES (
            ?,NOW(),?,?,?,?,?,?)");
        
        // get $_POST form values and bind.
        // set parameters and execute
                    
        $stmt->bind_param("ssssssi", $name, $fuel, $adblue, $mileage, $hours, $notes, $companyID);
                    
        $name      = $_POST['machineInput'];        
        $fuel      = $_POST['fuelInput'];
        $adblue      = $_POST['adblueInput'];
        $mileage      = $_POST['mileageInput'];
        $hours      = $_POST['hoursInput'];                
        $notes     = $_POST['notesTextarea'];
        $companyID     = $_SESSION['user_company_ID'];
        
        // check if atleast one field has input and then execute
        if ($_POST['fuelInput'] !="" || $_POST['adblueInput'] !="" || $_POST['hoursInput'] !="") {
            if ($stmt !== false) {
                $stmt->execute();                        
        
                echo "
                    <script src='vendor/jquery/jquery.min.js'></script>
                    <script>$(document).ready(function(){
                        alert('Ditt inlägg är sparat');
                        $('#page-content').load('content/page_schema.php');
                    });
                    </script>
                ";
        
                $stmt->close();
                $db->close();
                
            }else {
                die('prepare() failed: ' . htmlspecialchars($db->error));
                if(!$stmt){
                    echo "Error: " . mysqli_error($db);
                    }
            }
        } else {
            echo "
                    <script src='vendor/jquery/jquery.min.js'></script>
                    <script>$(document).ready(function(){
                        alert('Minst ett fält för bränsle, AdBlue eller timmar måste fyllas i');
                        $('#page-content').load('content/page_reportfuel.php');
                    });
                    </script>
                ";
        
                $stmt->close();
                $db->close();
        }
    
}

function deleteFuel(){

    // set global db variable from dbconnect
    global $db;
        
    $ID = $_POST['removeThisID'];

    $stmt = $db->prepare("DELETE FROM tbl_fuel
                          WHERE fu_ID = ?");

    $stmt->bind_param('i', $ID);

    if ($stmt !== false) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        
        echo "
            <script src='vendor/jquery/jquery.min.js'></script>
            <script>$(document).ready(function(){
                alert('Tankningen har tagits bort');
                    $('#page-content').load('content/page_reports_fuel.php');
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
}


function countAllMachines(){

    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT
                *
            FROM
                tbl_machine a            
            WHERE
                a.ma_owner = $company";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        return $count;        
    }    
}

function countAllVehicle(){

    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT
                *
            FROM
                tbl_vehicle a            
            WHERE
                a.ve_owner = $company";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        return $count;        
    }    
}

function countAllTools(){

    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT
                *
            FROM
                tbl_tools a            
            WHERE
                a.to_owner = $company";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        return $count;        
    }    
}

function countAllMaterials(){

    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT
                *
            FROM
                tbl_materials a            
            WHERE
                a.ma_owner = $company";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        return $count;        
    }    
}


function getUsersAllData($cuserID)
{
    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
    $sql = "SELECT * FROM tbl_user a
        LEFT JOIN tbl_employees b ON
        b.em_userID = a.us_ID
        WHERE b.em_companyID = $company
        AND a.us_ID = $cuserID
            ";
    
    $result = mysqli_query($db, $sql);
    
    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    $count = mysqli_num_rows($result);
    
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr><td class='text-nowrap'>Anst nr: </td><td class='text-nowrap font-weight-bold'>" . $row['us_employeenr'] . "</td></tr>";
            echo "<tr><td class='text-nowrap'>Förnamn: </td><td class='text-nowrap font-weight-bold'>" . $row['us_fname'] . "</td></tr>";
            echo "<tr><td class='text-nowrap'>Efternamn: </td><td class='text-nowrap font-weight-bold'>" . $row['us_lname'] . "</td></tr>";
            echo "<tr><td class='text-nowrap'>Person nr: </td><td class='text-nowrap font-weight-bold'>" . $row['us_pnr'] . "</td></tr>";
            echo "<tr><td class='text-nowrap'>Infotext: </td><td class='text-nowrap font-weight-bold'>" . $row['us_infotext'] . "</td></tr>";
            echo "<tr><td class='text-nowrap'>Adress 1: </td><td class='text-nowrap font-weight-bold'>" . $row['us_address1'] . "</td></tr>";
            echo "<tr><td class='text-nowrap'>Adress 2: </td><td class='text-nowrap font-weight-bold'>" . $row['us_address2'] . "</td></tr>";
            echo "<tr><td class='text-nowrap'>Post nr: </td><td class='text-nowrap font-weight-bold'>" . $row['us_zip'] . "</td></tr>";
            echo "<tr><td class='text-nowrap'>Stad: </td><td class='text-nowrap font-weight-bold'>" . $row['us_city'] . "</td></tr>";
            echo "<tr><td class='text-nowrap'>Epost: </td><td class='text-nowrap font-weight-bold'>" . $row['us_email'] . "</td></tr>";
            echo "<tr><td class='text-nowrap'>Telefon 1: </td><td class='text-nowrap font-weight-bold'>" . $row['us_phone1'] . "</td></tr>";
            echo "<tr><td class='text-nowrap'>Telefon 2: </td><td class='text-nowrap font-weight-bold'>" . $row['us_phone2'] . "</td></tr>";
            echo "<tr><td class='text-nowrap'>Bank clearing nr: </td><td class='text-nowrap font-weight-bold'>" . $row['us_clearingnr'] . "</td></tr>";
            echo "<tr><td class='text-nowrap'>Bank nr: </td><td class='text-nowrap font-weight-bold'>" . $row['us_accountnr'] . "</td></tr>";
            
        }
    }else {
        echo "<div class='alert alert-secondary' role='alert'>Inga poster hittades.</div>";
    }
    
    // free sql result
    mysqli_free_result($result);
    
    // return result
    return $result;
    
    // close connection
    $db->close();
}


// set global current week total work hours from time panel
$totalWeekHours = 0;
function setWeekTotalHours($hours)
{
    $GLOBALS['totalWeekHours'] = $hours;
}

// return total week hours
function getWeekTotalHours()
{
    global $totalWeekHours;
    return $totalWeekHours;
}

// set global current month total work hours to report time
$totalMonthHours = 0;
function setMonthTotalHours($hours)
{
    $GLOBALS['totalMonthHours'] += $hours;
}

// return total week hours
function getMonthTotalHours()
{
    global $totalMonthHours;
    return $totalMonthHours;
}

function getMonthName($cnr)
{
    
    $months = array(
        '1' => 'Jan',
        '2' => 'Feb',
        '3' => 'Mar',
        '4' => 'Apr',
        '5' => 'Maj',
        '6' => 'Jun',
        '7' => 'Jul',
        '8' => 'Aug',
        '9' => 'Sep',
        '10' => 'Okt',
        '11' => 'Nov',
        '12' => 'Dec'
    );

    if ($cnr) {
        $number = $cnr;
        foreach ($months as $key => $value) {
            if ($key == $number) {
                return $value;
            }
        }
    }else {
        foreach ($months as $key => $value) {
            return $value;
        }
    }
}

function getMonthNameSelectedList()
{
    
    $months = array(
        '1' => 'Jan',
        '2' => 'Feb',
        '3' => 'Mar',
        '4' => 'Apr',
        '5' => 'Maj',
        '6' => 'Jun',
        '7' => 'Jul',
        '8' => 'Aug',
        '9' => 'Sep',
        '10' => 'Okt',
        '11' => 'Nov',
        '12' => 'Dec'
    );
    return $months;
}

function getMonthFullName($cnr)
{
    
    $months = array(
        '1' => 'Januari',
        '2' => 'Februari',
        '3' => 'Mars',
        '4' => 'April',
        '5' => 'Maj',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Augusti',
        '9' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'December'
    );
    $number = $cnr;
    
    foreach ($months as $key => $value) {
        if ($key == $number) {
            return $value;
        }
    }
}

function getDayName($cnr)
{
    $days   = array(
        '0' => 'Sön',
        '1' => 'Mån',
        '2' => 'Tis',
        '3' => 'Ons',
        '4' => 'Tor',
        '5' => 'Fre',
        '6' => 'Lörd'
    );

    $number = $cnr;
    
    foreach ($days as $key => $value) {
        if ($key == $number) {
            return $value;
        }
    }
}

function transDayName($cname)
{
    $days   = array(
        'Sunday'    => 'Söndag',
        'Monday'    => 'Måndag',
        'Tuesday'   => 'Tisdag',
        'Wednesday' => 'Onsdag',
        'Thursday'  => 'Torsdag',
        'Friday'    => 'Fredag',
        'Saturday'  => 'Lördag'
    );

    $word = $cname;
    
    foreach ($days as $key => $value) {
        if ($key == $word) {
            return $value;
        }
    }
}

function getCurrentDate()
{
    $date = date("Y-m-d");
    return $date;
}

function getCurrentYear()
{
    $year = date("Y");
    return $year;
}

function getCurrentMonth()
{
    $month = date("m");
    return $month;
}

function getCurrentDay()
{
    $day = date("d");
    return $day;
}

function getCurrentWeek()
{
    $week = date("W");
    return $week;
}

function getCurrentMonthFullName()
{
    $monthNr = date("m");
    $month   = getMonthFullName($monthNr);
    return $month;
}
?>