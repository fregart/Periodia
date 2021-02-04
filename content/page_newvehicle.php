<?php session_start(); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-sm">

            <p class="h4">Lägg till nytt fordon</p>
            <br />


            <div class="col-lg-8 pb-5 card p-4" style="background-color:#dfe5e8;">
                <form method="POST" class="row">
                <input type="hidden" name="action" value="newVehicle">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="machinenameInput">Namn</label>
                            <input class="form-control" type="text" id="vehiclenameInput" name="vehiclenameInput" value="" required="">
                        </div>
                    </div>
                   
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="regnrInput">Reg.nummer</label>
                            <input class="form-control" type="text" id="regnrInput" name="regnrInput" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="mileageInput">Mätarställning</label>
                            <input class="form-control" type="text" id="mileageInput" name="mileageInput" value="">
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