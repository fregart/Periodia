<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>

<div class="container mt-4">
    <div class="row">
        <div class="col-sm-12">

            <p class="h4">Timmar per projekt</p>
            <br />

            <div class="alert alert-secondary">Tiden baseras på de timmar som rapporterats in.</div>

            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th scope="col">Namn</th>
                        <th scope="col">Eget-ID</th>
                        <th scope="col">Tidsram</th>
                        <th scope="col" class='text-right'>Timmar</th>
                    </tr>
                </thead>
                <tbody>                    

                    <?php getProjectReportList(); ?>

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