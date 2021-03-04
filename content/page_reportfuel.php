<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>
<?php

// get current date
$setDate = getCurrentDate();
?>

<!-- Report fuel -->

<div class="container-fluid">
    <h4 class="mt-4">Rapportera tankning</h4>
    <br />

    <div class="col-sm-12 col-m-8 col-lg-4">
        <div class="card" style="background-color:#dfe5e8;">
            <div class="card-body">       
            <form method="post">
        
            <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="machineInput">Maskin eller fordon</label>
                                <select class="form-control" id="machineInput" name="machineInput" required>
                                    <option value=""> -- Välj --</option>
                                    <?php echo getAllMachinesSelectList();?>
                                    <?php echo getAllVehiclesSelectList();?>
                                </select>
                            </div>
                        </div>                    
                    </div> 

                    
                    <input type="hidden" name="action" value="reportFuel" />     
                    <div class="row w-50">
                        <div class="form-group">
                            <div class="col">
                                <label for="dateInput">Datum</label>                            
                                <input type="date" class="form-control" id="dateInput" name="dateInput" value="<?php echo $setDate; ?>" />
                            </div>                            
                        </div>
                    </div>

                    <div class="row w-50">
                        <div class="form-group">
                            <div class="col">
                                <label for="fuelInput">Bränsle (liter)</label>                            
                                <input type="text" class="form-control" id="fuelInput" name="fuelInput" value="" />
                            </div>                            
                        </div>
                    </div>

                    <div class="row w-50">
                        <div class="form-group">
                            <div class="col">
                                <label for="adblueInput">AdBlue (liter)</label>                            
                                <input type="text" class="form-control" id="adblueInput" name="adblueInput" value="" />
                            </div>                            
                        </div>
                    </div>

                    <div class="row w-50">
                        <div class="form-group">
                            <div class="col">
                                <label for="mileageInput">Mätarställning</label>                            
                                <input type="text" class="form-control" id="mileageInput" name="mileageInput" value="" />
                            </div>                            
                        </div>
                    </div>

                    <div class="row w-50">
                        <div class="form-group">
                            <div class="col">
                                <label for="hoursInput">Timmar</label>                            
                                <input type="text" class="form-control" id="hoursInput" name="hoursInput" value="" />
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
                                <label for='notesTextarea'>Noteringar</label>
                                <textarea class='form-control' name='notesTextarea' id='notesTextarea' rows='5'></textarea>
                            </div>
                        </div>                    
                    </div>

                    <br>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success" title='Spara'>Spara</button>
                                <button type="button" class="btn btn-primary" title='Avbryt'>Avbryt</button>                          
                            </div>                                    
                        </div>
                    </div>
                </form>
        
            </div>
        </div>
    </div>
</div>

<script>


    // cancel button listener
    $(".btn-primary").click(function(){
        $('#page-content').load('content/page_schema.php');
    });
    
    
</script>
