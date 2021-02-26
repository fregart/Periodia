<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>

<!-- Lägg till nytt projekt -->
<section class="page-newproject">
    <div class="container-fluid">
        <h4 class="mt-4">Nytt projekt</h4>
        <br />

        <div class="col-sm-12 col-m-8 col-lg-4">
            <div class="card" style="background-color:#dfe5e8;">
            <div class="card-body">
            
            
            <form method="post">         
            <input type="hidden" name="action" value="newProject" />   
            <div class="row w-100">
                <div class="form-group">
                    <div class="col">
                        <label for="projectNameInput">Projektnamn</label>                            
                        <input type="text" class="form-control" id="projectNameInput" name="projectNameInput" value="" required="true" />
                    </div>
                    
                </div>
            </div>

            <div class="row w-50">
                <div class="form-group">
                    <div class="col">
                        <label for="internInput">Internt ID</label>                            
                        <input type="text" class="form-control form-control-sm" id="internInput" name="internInput" value="" />
                    </div>
                    
                </div>
            </div>

            
            <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="startDateInput">Startdatum</label>
                            <input type="date" class="form-control form-control-sm" id="startDateInput" name="startDateInput" value="" required="true" />
                        </div>
                    </div>                    
                    <div class="col">
                        <div class="form-group">
                            <label for="endDateInput">Slutdatum</label>
                            <input type="date" class="form-control form-control-sm" id="endDateInput" name="endDateInput" value="" />
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
                            <label for="descInput">Noteringar</label>
                            <textarea class="form-control" name="descInput" id="descInput" rows="5" placeholder="Kundinfo och kontaktuppgifter m.m."></textarea>                         
                        </div>
                    </div>                    
                </div>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-success" title='Spara'>Spara</button>
                            <button type="button" class="btn btn-primary" id="btn-avbryt" title='Avbryt'>Avbryt</button>
                            </form>
                        </div>
                
                    </div>                        
                </div>
            </form>

            </div>
            </div>

        </div>
    </div>
</section>
<script>

    // cancel button listener
    $("#btn-avbryt").click(function(){
        $('#page-content').load('content/page_projekt.php');
    });
    
</script>
