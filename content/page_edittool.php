<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>

<?php

    $ID= intval($_GET['id']);

    global $db;

    $sql = "SELECT *
            FROM
            tbl_tools a
            WHERE
            a.to_ID = $ID";
                    
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

            <p class="h4">Redigera verktyg</p>
            <br />

            <div class="col-lg-8 pb-5 card p-4" style="background-color:#dfe5e8;">
                <form method="POST" class="row">
                    <input type="hidden" name="action" value="editTool">
                    <input type="hidden" name="id" value="<?php echo $row['to_ID']?>">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="toolnameInput">Namn</label>
                            <input class="form-control" type="text" id="toolnameInput" name="toolnameInput"
                                value="<?php echo $row['to_name'] ?>" required="">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="descriptionInput">Beskrivning</label>
                            <textarea class="form-control" name="descriptionInput" id="descriptionInput"
                                rows="5"><?php echo $row['to_description'] ?></textarea>
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
                    <input type="hidden" name="action" value="deleteTool">
                    <input type="hidden" name="removeThisID" value="<?php echo $row['to_ID'] ?>">
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