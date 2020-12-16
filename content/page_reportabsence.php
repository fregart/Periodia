<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>
<?php
    // default values
    $row['wo_starttime'] = "07:00";
    $row['wo_endtime'] = "16:00";    
    $row['wo_notes'] = "";
?>
<!-- Rapportera frånvaro -->
<section class="page-reporttime">
    <div class="container-fluid">
        <h4 class="mt-4">Rapportera frånvaro</h4>
        <br />

        <div class="col-sm-12 col-m-8 col-lg-4">
            <div class="card" style="background-color:#dfe5e8;">
            <div class="card-body">
            
            
            <form method="post">         
            <input type="hidden" name="action" value="reportAbsence" />     
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="datumfrånInput">Från</label>
                        <input type="date" class="form-control" id="datumfrånInput" name="datumfrånInput" value="<?php echo getCurrentDate(); ?>" />
                    </div>
                </div>                    
                
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                    <label for="datumtillInput">Till</label>
                        <input type="date" class="form-control" id="datumtillInput" name="datumtillInput" value="<?php echo getCurrentDate(); ?>" />
                    </div>
                </div>                    

            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="timmarInput">Timmar/dag</label>
                        <input type="text" class="form-control" id="timmarInput" name="timmarInput" value="" />
                    </div>
                </div>                    
                <div class="col">
                    <div class="form-group">
                        <label for="procentInput">% /dag</label>
                        <input type="text" class="form-control" id="procentInput" name="procentInput" value="" />
                    </div>
                </div>                    
            </div>

            


                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="absenceTypeInput">Frånvarotyp</label>
                            <select class="form-control" id="absenceTypeInput" name="absenceTypeInput">
                                <?php getAllAbscenceTypeSelectList();?>                    
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
                            <textarea class="form-control" name="notesInput" rows="5" ></textarea>                         
                        </div>
                    </div>                    
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Spara</button>
                    <button type="button" class="btn btn-primary">Avbryt</button>
                </div>
            </form>

            </div>
            </div>

        </div>
    </div>
</section>
<script>
    // cancel button listener
    $(".btn-primary").click(function(){
        $('#page-content').load('content/page_schema.php');
    });
</script>
