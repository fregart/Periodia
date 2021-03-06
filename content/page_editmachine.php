<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>

<?php

    $machineID= intval($_GET['id']);

    global $db;

    $sql = "SELECT *
            FROM
            tbl_machine a
            WHERE
            a.ma_ID = $machineID";
                    
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

            <p class="h4">Redigera maskin</p>
            <br />

            <div class="col-lg-8 pb-5 card p-4" style="background-color:#dfe5e8;">
                <form method="POST" class="row">
                    <input type="hidden" name="action" value="editMachine">
                    <input type="hidden" name="id" value="<?php echo $row['ma_ID']?>">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="machinenameInput">Namn</label>
                            <input class="form-control" type="text" id="machinenameInput" name="machinenameInput"
                                value="<?php echo $row['ma_name'] ?>" required="">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="regnrInput">Reg.nummer</label>
                            <input class="form-control" type="text" id="regnrInput" name="regnrInput"
                                value="<?php echo $row['ma_regnr'] ?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="mileageInput">Mätarställning</label>
                            <input class="form-control" type="text" id="mileageInput" name="mileageInput"
                                value="<?php echo $row['ma_mileage'] ?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="hoursInput">Arbetstimmar</label>
                            <input class="form-control" type="text" id="hoursInput" name="hoursInput"
                                value="<?php echo $row['ma_hours'] ?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="descriptionInput">Beskrivning</label>
                            <textarea class="form-control" name="descriptionInput" id="descriptionInput"
                                rows="5"><?php echo $row['ma_description'] ?></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr class="mt-2 mb-3">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-success" title='Spara'>Spara</button>
                                    <button type="button" class="btn btn-primary" title='Avbryt'>Avbryt</button>
                </form>
            </div>


            <div class="col">
                <form method="POST">
                    <input type="hidden" name="action" value="deleteMachine">
                    <input type="hidden" name="removeThisID" value="<?php echo $row['ma_ID'] ?>">
                    <button type='submit' class='btn btn-danger' id='btndelete' title='Ta bort' disabled>Ta
                        bort</button>
                    <div class='form-check'>
                        <br>
                        <input type='checkbox' class='form-check-input' id='enableCheck'>
                        <label class='form-check-label' for='enableCheck'>
                            <p class='small'>Aktivera</p>
                        </label>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
</div>
</div>
</div>
<script>
// enables the delete button on checked
$('#enableCheck').click(function() {

    if ($(this).is(':checked')) {
        $('#btndelete').removeAttr('disabled');

    } else {
        $('#btndelete').attr('disabled', true);
    }
});

// cancel button listener
$(".btn-primary").click(function() {
    $('#page-content').load('content/page_equipment.php');
});
</script>