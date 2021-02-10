<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>
<?php

global $db;

$userID = $_SESSION['user_ID'];

  $sql = "SELECT *
          FROM
            tbl_user a
          WHERE
            a.us_ID = $userID";

                       
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

<div class="container mt-4">
    <div class="row">
        <div class="col-sm">

            <p class="h4">Profil</p>
            <br />


            <div class="col-lg-8 pb-5 card p-4" style="background-color:#dfe5e8;">
                <form method="POST" class="row">
                <input type="hidden" name="action" value="updateUserProfile">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="account-fn">Användarnamn</label>
                            <input class="form-control" type="text" id="usernameInput" name="usernameInput" value="<?php echo $row['us_username'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="account-fn">Förnamn</label>
                            <input class="form-control" type="text" id="firstnameInput" name="firstnameInput" value="<?php echo $row['us_fname'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="account-ln">Efternamn</label>
                            <input class="form-control" type="text" id="lastnameInput" name="lastnameInput" value="<?php echo $row['us_lname'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="account-email">E-post adress</label>
                            <input class="form-control" type="email" id="emailInput" name="emailInput" value="<?php echo $row['us_email'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="account-phone">Telefon 1</label>
                            <input class="form-control" type="text" id="phone1Input" name="phone1Input" value="<?php echo $row['us_phone1'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="account-phone">Telefon 2</label>
                            <input class="form-control" type="text" id="phone2Input" name="phone2Input" value="<?php echo $row['us_phone2'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="account-pass">Nytt lösenord</label>
                            <input class="form-control" type="password" id="pass1Input" name="pass1Input" value="<?php echo $row['us_password'] ?>" onkeyup="validatePassword(this)" required="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="account-confirm-pass">Bekräfta lösenord</label>
                            <input class="form-control" type="password" id="pass2Input" name="pass2Input" value="<?php echo $row['us_password'] ?>" onkeyup="validatePassword(this)" required="">
                        </div>
                    </div>
                    <div class="col-12">
                        <hr class="mt-2 mb-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <button class="btn btn-success" type="submit">Spara</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>