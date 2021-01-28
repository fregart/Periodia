<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>

<!-- Staff -->
<div class="container-fluid">
    <h4 class="mt-4">Personal</h4>
    <br>
    <div class="row">
        <div class="col-12 col-sm-12 col-lg-12">

            <br>

            <table class="table table table-striped table-hover table-m table-bordered table-sm">
            <thead>
                <tr colspan="4">
                <h5>Incheckad personal</h5>
                </tr>
                <tr>
                    <th scope="col">Projekt</th>
                    <th scope="col">Namn</th>
                    <th scope="col">Tid</th>
                    <th scope="col">Hantera</th>
    
                </tr>
            </thead>
            <tbody>
               <?php getCheckedInUsers(); ?> 
            </tbody>
            </table>


            
            <br>

            <table class="table table table-striped table-hover table-m table-bordered table-sm">
            <thead>
                <tr colspan="4">
                    <h5>Checka in personal</h5>
                </tr>
                <tr>
                    <th scope="col">Projekt</th>
                    <th scope="col">Namn</th>
                    <th scope="col"></th>
                    <th scope="col">Hantera</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row">Snöskottning</th>
                <td>Hampus</td>
                <td></td>
                <td><button class='btn btn-success btn-sm' id='checkoutbutton' title='Checka in'><i class='fas fa-user-plus'></i></button></td>
                
                </tr>
                
            </tbody>
            </table>
        
        </div>
    </div>
</div>