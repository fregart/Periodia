<?php session_start(); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-sm">

            <p class="h4">Lägg till nytt materiel</p>
            <br />


            <div class="col-lg-8 pb-5 card p-4" style="background-color:#dfe5e8;">
                <form method="POST" class="row">
                <input type="hidden" name="action" value="newMaterial">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="materialnameInput">Namn</label>
                            <input class="form-control" type="text" id="materialnameInput" name="materialnameInput" value="" required="">
                        </div>
                    </div>
                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descriptionInput">Beskrivning</label>
                            <textarea class="form-control" name="descriptionInput" id="descriptionInput" rows="5"></textarea>
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