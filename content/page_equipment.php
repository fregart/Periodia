<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>


<div class="row">
    <div class="col">
        <div class="accordion" id="accordionPeriodia">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Maskiner <span class="badge badge-primary badge-pill"><?php echo countAllMachines(); ?></span>
                        </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionPeriodia">
                    <div class="card-body">

                        <div class="row">
                            <div class="col">
                                <?php
                                    if ($_SESSION['user_role'] == 2) {?>
                                <button class="btn btn-primary btn-sm float-right" id="btn-add-new-machine" title="Lägg till ny maskin">
                                    <i class="fa fa-plus-circle"></i> <span>Lägg till</span></button>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>

                        <p></p>


                        <div class="row">
                            <div class="col">
                               
                                <?php 
                                    getAllMachines();
                                ?>
                                  
                            </div>
                        </div>





                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Fordon <span class="badge badge-primary badge-pill"><?php echo countAllVehicle(); ?></span>
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionPeriodia">
                    <div class="card-body">
                        
                    <div class="row">
                            <div class="col">
                                <?php
                                    if ($_SESSION['user_role'] == 2) {?>
                                <button class="btn btn-primary btn-sm float-right" id="btn-add-new-vehicle" title="Lägg till nytt fordon">
                                    <i class="fa fa-plus-circle"></i> <span>Lägg till</span></button>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>

                        <p></p>


                        <div class="row">
                            <div class="col">
                               
                                <?php 
                                    getAllVehicles();
                                ?>
                                  
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Verktyg <span class="badge badge-primary badge-pill"><?php echo countAllTools(); ?></span>
                        </button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionPeriodia">
                    <div class="card-body">
                    <div class="row">
                            <div class="col">
                                <?php
                                    if ($_SESSION['user_role'] == 2) {?>
                                <button class="btn btn-primary btn-sm float-right" id="btn-add-new-tool" title="Lägg till nytt verktyg">
                                    <i class="fa fa-plus-circle"></i> <span>Lägg till</span></button>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>

                        <p></p>


                        <div class="row">
                            <div class="col">
                               
                                <?php 
                                    getAllTools();
                                ?>
                                  
                            </div>
                        </div>

                    </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingFour">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Materiel <span class="badge badge-primary badge-pill"><?php echo countAllMaterials(); ?></span>
                        </button>
                    </h2>
                </div>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionPeriodia">
                    <div class="card-body">
                       

                    <div class="row">
                            <div class="col">
                                <?php
                                    if ($_SESSION['user_role'] == 2) {?>
                                <button class="btn btn-primary btn-sm float-right" id="btn-add-new-material" title="Lägg till nytt materiel">
                                    <i class="fa fa-plus-circle"></i> <span>Lägg till</span></button>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>

                        <p></p>


                        <div class="row">
                            <div class="col">
                               
                                <?php 
                                    getAllMaterials();
                                ?>
                                  
                            </div>
                        </div>

                    </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {

    // machine list click listener
    $(document).on("click", "#machine-link", function() {
        var id = $(this).attr('maid');
        $("#page-content").load('content/page_showmachine.php?id=' + id, true);
    });    

    // add new machine button listener
    $("#btn-add-new-machine").click(function() {
        $('#page-content').load('content/page_newmachine.php');
    });

    // vehicle list click listener
    $(document).on("click", "#vehicle-link", function() {
        var id = $(this).attr('maid');
        $("#page-content").load('content/page_showvehicle.php?id=' + id, true);
    });    

    // add new vehicle button listener
    $("#btn-add-new-vehicle").click(function() {
        $('#page-content').load('content/page_newvehicle.php');
    });

    // tool list click listener
    $(document).on("click", "#tool-link", function() {
        var id = $(this).attr('maid');
        $("#page-content").load('content/page_showtool.php?id=' + id, true);
    });    

    // add new tool button listener
    $("#btn-add-new-tool").click(function() {
        $('#page-content').load('content/page_newtool.php');
    });

    // material list click listener
    $(document).on("click", "#material-link", function() {
        var id = $(this).attr('maid');
        $("#page-content").load('content/page_showmaterial.php?id=' + id, true);
    });    

    // add new material button listener
    $("#btn-add-new-material").click(function() {
        $('#page-content').load('content/page_newmaterial.php');
    });

});
</script>