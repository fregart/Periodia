<?php   
require_once("dbconnect.php");
$error = "";   
session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      // username and password sent from form      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);      

      $sql = "SELECT us_ID, us_roleID, us_isactive FROM tbl_user WHERE us_username = '$myusername' and us_password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      
      // print error message if user is not in the database
      if (!$result) {
        printf("Error: %s\n", mysqli_error($db));        
        exit();
      }
      
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);                        
      $count = mysqli_num_rows($result);
      
      // if result matched $myusername and $mypassword, table row must be 1 row
      if($count == 1) {

         $myID = $row['us_ID'];
         $myrole = $row['us_roleID'];
         $active = $row['us_isactive'];

         // check if user is active
         // if not restrict access and print error message
         if ($active == 0) {
            $error = "Ditt konto är inte aktivt, kontakta admin";
            

         }elseif ($active == 1) {

            // session_register("myusername");
         $_SESSION['login_user'] = $myusername;

         // session_register("myrole");
         $_SESSION['user_role'] = $myrole;

         // session_register("myID");
         $_SESSION['user_ID'] = $myID;

         // get company info
         $sql2 = "SELECT a.co_ID, a.co_name, a.co_orgnbr, a.co_description, a.co_startdate, a.co_enddate, a.co_isactive FROM tbl_company a LEFT JOIN tbl_employees b ON a.co_ID = b.em_companyID WHERE b.em_userID = $myID";
         
         $result2 = mysqli_query($db,$sql2);

         $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);      
                  
         // session_register company info;
         $_SESSION['user_company_ID'] = $row2['co_ID'];         
         $_SESSION['user_company'] = $row2['co_name'];
         $_SESSION['user_company_nr'] = $row2['co_orgnbr'];
         $_SESSION['user_company_desc'] = $row2['co_description'];
         $_SESSION['user_company_start'] = $row2['co_startdate'];
         $_SESSION['user_company_end'] = $row2['co_enddate'];
         $_SESSION['user_company_isactive'] = $row2['co_isactive'];
         
         // set sessiontime depending on checkbox remember is checked
         $sessiontime;
         if (isset($_POST['remember'])) {
            $sessiontime = 86400;            
         }else {
            $sessiontime = 600;            
         }                  
         setcookie("Checkbox", $sessiontime, time() + (200), "/");     
         
         // show index page
         header("location: index.php");     

         // free sql result
         mysqli_free_result($result);

         $db->close();
         }

         
      }else {
         $error = "Användarnamn eller <br>
                     lösenord är felaktigt.<br>
                     Vid fortsatta problem <br>
                     kontakta admin.";         
      }
   }
?>
<html>

   <head>
      <title>Periodia - Logga in</title>

      <!-- Viewport -->
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

      <!-- Custom CSS -->
      <link rel="stylesheet" href="css/style.css">              

      <meta charset="utf-8">

      

   </head>

   <body class="log-in-bg">



   <div class="container">
      <div class="row h-100">
      <div class="col-md d-flex justify-content-center my-auto">
            <div class="card">
               <div class="card-body">
                  <img src="img/periodia-logo-gul.png" width="220" alt="Periodia logotype" class="d-inline-block align-middle mr-2"><br /><br />
                  <h6 class="card-subtitle mb-2 text-muted">Logga in</h6>

                  <form class="form-group" action = "" method = "post">
                     <label>Användare  :</label><input type = "text" name = "username" class = "form-control"/><br />
                     <label>Lösenord  :</label><input type = "password" name = "password" class = "form-control" /><br/>
                     <label for="remember"> Kom ihåg mig</label> <input type="checkbox" id="remember" name="remember" value="true"><br /><br />
                     <input type = "submit" value = " Logga in " class="btn btn-primary mb-2" /><br />
                  </form>
               
                  <?php    
                     if (!($error == "")) {
                     echo "<div class='alert alert-danger'>";
                     echo $error;
                     echo "</div>";
                  } ?>          

                        
               </div>

            </div>

         </div>
         
      </div>
   </div>
 

   
  


   </body>
</html>
