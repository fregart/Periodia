<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>
<?php 

$ID= intval($_GET['id']);

global $db;

$sql = "SELECT *
FROM tbl_vehicle a    
WHERE a.ve_ID = $ID";
                        
$result = mysqli_query($db,$sql);

// print error message if something happend
if (!$result) {
    printf("Error: %s\n", mysqli_error($db));        
    exit();
}    

if($result = $db->query($sql)){
    echo "<div class='container mt-4'>";
    
    while($row = mysqli_fetch_array($result)) {
        echo "<div class='card'>";
            echo "<div class='card-body'>";
                echo "<strong>" . $row['ve_name'] . " " . $row['ve_regnr'] . "</strong><br>";
                echo "<hr>";
                echo "<div class='row'><div class='col-sm-6 col-lg-4'>Reg. nr. </div><div class='col-sm-6 col-lg-4'>" . $row['ve_regnr'] . "<div class='col-auto'></div></div></div>";
                echo "<hr>";
                echo "<div class='row'><div class='col-sm-6 col-lg-4'>Mätarställning </div><div class='col-sm-6 col-lg-4'>" . $row['ve_mileage'] . "<div class='col-auto'></div></div></div>";
                echo "<hr>";
                echo "<div class='row'><div class='col-sm-6 col-lg-4'>Beskrivning <p></p></div><div class='col-sm-6 col-lg-4'>" . $row['ve_description'] . "<div class='col-auto'></div></div></div>";        
                
                echo "<hr>";

                echo "
                <div class='form-group'>
                    <div class='row'>
                        <div class='col'>
                            <button type='button' class='btn btn-primary' title='Stäng'>Stäng</button>                  
                        </div>";
                        if ($_SESSION['user_role'] == 2) {
                            echo "<div class='col'>";
                            echo "<button class='btn btn-success' id='btn-edit-vehicle' maid='" . $row['ve_ID'] . "' title='Redigera'>Redigera</button>";
                            echo "</div>";
                        }
                    echo "
                    </div>
                </div>";
            
                echo "</div>";
        echo "</div>";
    }
   
    echo "</div>";
}?>
<script>
    // cancel button listener
    $(".btn-primary").click(function() {
    $('#page-content').load('content/page_equipment.php');
    });

    // vehicle edit button click listener
    $(document).on("click", "#btn-edit-vehicle", function() {
        var id = $(this).attr('maid');
        $("#page-content").load('content/page_editvehicle.php?id=' + id, true);
    });
</script>