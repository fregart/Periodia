<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>
<?php

if(isset($_GET['setAbsenceID'])){    
    
    $absenceID = $_GET['setAbsenceID'];
    
    $sql = "SELECT *
    FROM
      tbl_absence a
    LEFT JOIN tbl_absencetype b ON a.ab_type=b.abt_ID
    WHERE
      a.ab_ID = $absenceID";
                    
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
    <h4 class="mt-4">Uppdatera frånvaro</h4>
    <br />

    <div class="col-sm-12 col-m-8 col-lg-4">
        <div class="card" style="background-color:#dfe5e8;">
            <div class="card-body">


                <form method="post">
                    <input type="hidden" name="action" value="reportAbsence" />                    
                    <div class="row w-50">
                        <div class="col">
                            <div class="form-group">
                                <label for="datumfrånInput">Från</label>
                                <input type="date" class="form-control" id="datumfrånInput" name="datumfrånInput"
                                    value="<?php echo $row['ab_startdate'] ?>" />
                            </div>
                        </div>

                    </div>

                    <div class="row w-50">
                        <div class="col">
                            <div class="form-group">
                                <label for="datumtillInput">Till</label>
                                <input type="date" class="form-control" id="datumtillInput" name="datumtillInput"
                                    value="<?php echo $row['ab_enddate'] ?>" />
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="timmarInput">Timmar/dag</label>
                                <input type="text" class="form-control" id="timmarInput" name="timmarInput" value="<?php echo $row['ab_hours'] ?>" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="procentInput">% /dag</label>
                                <input type="text" class="form-control" id="procentInput" name="procentInput"
                                    value="<?php echo $row['ab_percent'] ?>" />
                            </div>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="absenceTypeInput">Frånvarotyp</label>
                                <select class="form-control" id="absenceTypeInput" name="absenceTypeInput">
                                    <?php getAbsenceSelectList($row['ab_type']);?>
                                </select>
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
                                <textarea class="form-control" name="notesInput" rows="5"><?php echo $row['ab_notes'] ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Spara</button>
                        <button type="button" class="btn btn-primary">Avbryt</button>
                    </div>
                </form>


                <div class="col">
                    <form method="post">

                        <input type="hidden" name="action" value="deleteAbsence">
                        <input type="hidden" name="removeThisID" value="<?php echo $absenceID ?>">
                        <button type='submit' class='btn btn-danger' id='btndelete' title='Ta bort' disabled>Ta
                            bort</button>
                        <div class='form-check'>
                            <br>
                            <input type='checkbox' class='form-check-input' id='enableCheck'>
                            <label class='form-check-label' for='enableCheck'>
                                <p class='small'>Aktivera</p>
                            </label>

                    </form>
                </div>
            </div>



        </div>


    </div>
</div>

</div>
</div>


<?php
}
?>




<script>
// cancel button listener
$(".btn-primary").click(function() {
    $('#page-content').load('content/page_myhours.php');
});

// enables the delete button on checked
$('#enableCheck').click(function() {

    if ($(this).is(':checked')) {
        $('#btndelete').removeAttr('disabled');

    } else {
        $('#btndelete').attr('disabled', true);
    }
});
</script>