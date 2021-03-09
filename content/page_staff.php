<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>


<?php 
    if (isset($_GET['setUser'])) {
        $cuserID = $_GET['setUser'];
    } else {
        $cuserID = $_SESSION['user_ID'];                
    }    

    global $db;

    $sql = "SELECT *
    FROM tbl_user a    
    WHERE a.us_ID = $cuserID";
                            
    $result = mysqli_query($db,$sql);

    // print error message if something happend
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));        
        exit();
    }    

    if($result = $db->query($sql)){
        $row = mysqli_fetch_array($result);
    }
?>


<div class="container-fluid">
    <h4 class="mt-4">Personalkort</h4>
    <br>

    <form method="post">
        <div class="row">
            <div class="col-sm-12 col-lg-6">

                <input type="hidden" name="action" value="updatePersonalCard" />
                <input type="hidden" name="userID" value="<?php echo $cuserID ?>" />

                <div class="form-group">
                    <label for="employeeInput" class="col-sm-2 col-form-label">Användare: </label>
                    <div class="col-sm-4">
                        <select class="form-control form-control-sm" name="employeeInput" id="employeeInput">
                            <?php                                
                                getEmployeeSelectedList($cuserID);                                                                                                                                                                                                                    
                            ?>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        

        <div class="row">
            <div class="col-sm-12 col-lg-6">

                <div class="card">
                    <div class="card-body">
                        <h6><strong>Personuppgifter</strong></h6>
                        <br>


                        <div class="m-t-30 text-center"><img src="/img/no-image.png"
                                class="img-circle" width="150" title="Ingen bild">
                            <h4 class="card-title m-t-10"><?php echo $row['us_fname'] ?> <?php echo $row['us_lname'] ?></h4>
                            
                            <div class="row text-center justify-content-md-center">
                            </div>
                        </div>


<hr>


                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputAnst-ID">Anställnings-ID</label>
                                    <input type="text" class="form-control" id="inputAnst-ID" name="inputAnst-ID"
                                        value="<?php echo $row['us_employeenr'] ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">

                                </div>
                            </div>

                        </div>



                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputPnr">Personnummer</label>
                                    <input type="text" class="form-control" id="inputPnr" name="inputPnr"
                                        placeholder="19701215-5545" value="<?php echo $row['us_pnr'] ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">

                                </div>
                            </div>

                        </div>




                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputFname">Förnamn</label>
                                    <input type="text" class="form-control" id="inputFname" name="inputFname"
                                        value="<?php echo $row['us_fname'] ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputLname">Efternamn</label>
                                    <input type="text" class="form-control" id="inputLname" name="inputLname"
                                        value="<?php echo $row['us_lname'] ?>">
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputInfotext">Infotext</label>
                                    <textarea class="form-control" id="inputInfotext" name="inputInfotext"
                                        rows="5"><?php echo $row['us_infotext'] ?></textarea>
                                </div>
                            </div>

                        </div>



                        <hr>


                        <h6><strong>Kontaktuppgifter</strong></h6>
                        <br>

                        <div class="form-group">
                            <label for="inputAddress1">Postadress</label>
                            <input type="text" class="form-control" id="inputAddress1" name="inputAddress1"
                                placeholder="Storgatan 12" value="<?php echo $row['us_address1'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Postadress 2</label>
                            <input type="text" class="form-control" id="inputAddress2" name="inputAddress2"
                                placeholder="Co" value="<?php echo $row['us_address2'] ?>">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="inputZip">Postnr</label>
                                <input type="text" class="form-control" id="inputZip" name="inputZip"
                                    placeholder="123 45" value="<?php echo $row['us_zip'] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity">Stad</label>
                                <input type="text" class="form-control" id="inputCity" name="inputCity"
                                    placeholder="Storstad" value="<?php echo $row['us_city'] ?>">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input type="text" class="form-control" id="inputEmail" name="inputEmail"
                                placeholder="example@example.com" value="<?php echo $row['us_email'] ?>">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputPhone1">Telefon 1</label>
                                <input type="text" class="form-control" id="inputPhone1" name="inputPhone1"
                                    value="<?php echo $row['us_phone1'] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPhone2">Telefon 2</label>
                                <input type="text" class="form-control" id="inputPhone2" name="inputPhone2"
                                    value="<?php echo $row['us_phone2'] ?>">
                            </div>
                        </div>

                        <hr>


                        <h6><strong>Utbetalning</strong></h6>
                        <br>


                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="inputClearnr">Clearingnr</label>
                                <input type="text" class="form-control" id="inputClearnr" name="inputClearnr"
                                    placeholder="3300" value="<?php echo $row['us_clearingnr'] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputAccountnr">Bankkontonr</label>
                                <input type="text" class="form-control" id="inputAccountnr" name="inputAccountnr"
                                    placeholder="19701113" value="<?php echo $row['us_accountnr'] ?>">
                            </div>

                        </div>

                        <hr>

                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-success" title='Spara'>Spara</button>
                                    <button type="button" class="btn btn-primary" id="btn-avbryt"
                                        title='Avbryt'>Avbryt</button>
    </form>
</div>
</div>
</div>



</div>


</div>

</div>

</div>
</form>



</div>
<script>
// employee select listener on change
$("#employeeInput").change(function() {

    var $cuser = $("#employeeInput").children("option:selected").val();

    var $file = 'page_staff' + '.php?setUser=' + $cuser;
    var $path = 'content/';

    $('#page-content').load($path + $file);

});

// cancel button listener
$("#btn-avbryt").click(function() {
    $('#page-content').load('content/page_schema.php');
});
</script>