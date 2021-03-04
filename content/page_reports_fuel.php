<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>

<div class="container mt-4">
    <div class="row">
        <div class="col-sm">

            <p class="h4">Senaste tankningar</p>
            <br />

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Datum</th>
                        <th scope="col">Namn</th>
                        <th scope="col">Bränsle (liter)</th>
                        <th scope="col">AdBlue</th>
                        <th scope="col">Mätarställning</th>
                        <th scope="col">Timmar</th>
                        <th scope="col">Notering</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php getFuelReports(); ?>
                    
                </tbody>
            </table>

        </div>
    </div>
</div>