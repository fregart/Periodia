<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>

<div class="container mt-4">
    <div class="row">
        <div class="col-sm-12">

            <p class="h4">Senaste tankningar</p>
            <br />

            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th scope="col">Datum</th>
                        <th scope="col">Namn</th>
                        <th scope="col" class='text-right'>Bränsle</th>
                        <th scope="col" class='text-right'>AdBlue</th>
                        <th scope="col" class="d-none d-lg-table-cell text-right">Mätare</th>
                        <th scope="col" class="d-none d-lg-table-cell text-right">Timmar</th>
                        <th scope="col" class="d-none d-lg-table-cell">Notering</th>
                    </tr>
                </thead>
                <tbody>

                    <?php getFuelReports(); ?>

                </tbody>
            </table>


            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-primary" title='Stäng'>Stäng</button>
                        </form>
                    </div>
                </div>
            </div>
            

        </div>
    </div>
</div>
<script>
// cancel button listener
$(".btn-primary").click(function() {
    $('#page-content').load('content/page_reports.php');
});
</script>