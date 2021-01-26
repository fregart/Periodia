<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "dbconnect.php";

// ------------------------------
// Call functions from post forms
// ------------------------------

if (isset($_POST['action'])) {

    /**echo "<pre>";
    echo var_dump($_POST);
    echo "</pre>";   **/
    
    if ($_POST['action'] == 'updateUser') {
        updateUserInfo(); // call function
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
    
    $sql = "SELECT a.us_ID, a.us_username, a.us_isactive, a.us_roleID, c.ro_name FROM tbl_user a LEFT JOIN tbl_employees b ON b.em_userID=a.us_ID LEFT JOIN tbl_role c ON c.ro_ID=a.us_roleID WHERE b.em_companyID = $company";
    
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
            echo "<td><a href='#' onclick='showUser(" . $row["us_ID"] . ")' aria-hidden='true' data-toggle='modal' data-target='#editUserModal' id='" . $row["us_ID"] . "'>" . $row["us_username"] . "</a></td>";
            echo "<td class='d-none d-lg-table-cell'> </td>";
            echo "<td class='text-center d-none d-lg-table-cell'>" . ucfirst($row["ro_name"]) . "</td>";
            echo "<td class='text-left d-none d-lg-table-cell'>";
            if ($row["us_isactive"] == 1) {
                echo "<i class='fas fa-circle fa-xs text-success'></i> <span class='text-muted small'>Aktiv</span>";
            } else {
                echo "<i class='fas fa-circle fa-xs text-danger'></i> <span class='text-muted small'>Passiv</span>";
            }
            echo "</td>";
            
            echo "<td><a href='#' class='updateUserLink' onclick='showUser(" . $row["us_ID"] . ")' title='Redigera'><i class='fas fa-pencil-alt text-warning mr-4' aria-hidden='true' data-toggle='modal' data-target='#editUserModal'></i></a>";
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
    echo "<pre>";
        var_dump($_POST);
    echo "</pre>";


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
    $stmt->bind_param("sii", $noteInput, $userID, $projectIDInput);
    
    $noteInput = mysqli_real_escape_string($db, $_POST['notesTextarea']);
    $userID = $_SESSION['user_ID'];
    $projectIDInput = $_POST['projectIDInput'];        


    if ($stmt !== false) {
        $stmt->execute();
        
    }else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
        if(!$stmt){
            echo "Error: " . mysqli_error($db);
            }
    }
    $stmt->close();

    
    // get last added note ID from tbl_notes
    $stmt   = "SELECT MAX(no_ID) FROM tbl_notes";
    $result = mysqli_query($db, $stmt);
    $row  = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

   

        

    var_dump($count);

    // if row was found insert noteID and file information to tbl_image
    if ($count == 1) {

        $noteID = $row['MAX(no_ID)'];        

        $name = $_FILES['fileToUpload']['name'];
        $target_dir = "upload/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

        // Select file type
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Valid file extensions
        $extensions_arr = array("jpg","jpeg","png","gif");

        // Check extension
        if( in_array($imageFileType,$extensions_arr) ){

        // Insert record
        $query = "insert into tbl_image(im_name, im_noteID) values('".$name."','".$noteID."')";
        
        // execute
        if (mysqli_query($db,$query)) {
            
            $uploadOk = 1;
            // Upload file
            //move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);
            
        } else {
            $uploadOk = 0;
        }
                    

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$name)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        
        
        

        
        }
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
    
    $sql = "SELECT a.ma_ID, a.ma_name, a.ma_regnr, a.ma_hours, a.ma_mileage, a.ma_status FROM tbl_machine a WHERE a.ma_owner = $company";
    
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
            echo "<td><a href='#' id='" . $row["ma_ID"] . "'>" . $row["ma_name"] . "</a></td>";
            echo "<td>" . $row["ma_regnr"] . "</td>";
            echo "<td class='d-none d-lg-table-cell'>" . $row["ma_hours"] . "</td>";
            echo "<td class='d-none d-lg-table-cell'>" . $row["ma_mileage"] . "</td>";
            echo "<td class='text-left'>";
            if ($row["ma_status"] == 1) {
                echo "<i class='fas fa-circle fa-xs text-success'></i> <span class='text-muted small'>Aktiv</span>";
            } else {
                echo "<i class='fas fa-circle fa-xs text-danger'></i> <span class='text-muted small'>Passiv</span>";
            }
            echo "</td>";
            
            echo "<td><a href='#' class='updateUserLink' onclick='showUser(" . $row["ma_ID"] . ")' title='Redigera'><i class='fas fa-pencil-alt text-warning mr-4' aria-hidden='true' data-toggle='modal' data-target='#editMachineModal'></i></a>";
            
            echo "<a href='#' class='deleteUserLink' title='Ta bort'><i class='fa fa-times-circle text-danger' aria-hidden='true' data-toggle='modal' data-target='#removeUserModal' data-user-id=" . $row["ma_ID"] . " data-user-name=" . $row["ma_name"] . "></i></a></td>";
            
            
            
            
            
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

function getAllAbscenceTypeSelectList()
{
    
    global $db;
    
    $company = $_SESSION['user_company_ID'];
    
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
    $date   = $_POST['removeThisDate'];
    
    $stmt = $db->prepare("DELETE
                            FROM
                                tbl_workinghours
                            WHERE
                                wo_userID   = ?
                            AND wo_date     = ?");
    $stmt->bind_param('is', $userID, $date);
    
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
        
    if(isset($_SESSION['user_ID'])){ 
        $userID = $_SESSION['user_ID'];
    } else{ 
      header("location:login.php");
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

function getWorkHoursForMonth($cuserID, $cmonth)
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
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";

    }

}

function getWorkedHoursForReport($cuserID, $cyear, $cmonth)
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
            <tr>
                <td>".$row["wo_date"]."
                <br>
                <div class='ml-1 small'>".$row["pr_name"]."</div>
                </td>
                <td class='text-center'>".$row["wo_starttime"]."</td>
                <td class='text-center'>".$row["wo_endtime"]."</td>
                <td class='text-center'>".$row["wo_rest"]."</td>
                <td class='text-center'>".$row["wo_total"]."</td>
            </tr>";
        }

    }

}

function getUserFullName($cuserID){

    global $db;
            
    $sql = "SELECT            
            a.us_fname,
            a.us_lname
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

            if ($first || $last) {
                echo $first, " ", $last;
            } else {
                echo "<div class='small text-danger'>Fullt namn saknas</div>";
            }                                                
        }                            
        
    }else {
        return null;
    }    

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

function getCurrentMonthFullName()
{
    $monthNr = date("m");
    $month   = getMonthFullName($monthNr);
    return $month;
}
?>