<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>
<?php 

$ID= intval($_GET['id']);

global $db;

$sql = "SELECT *
FROM tbl_materials a    
WHERE a.ma_ID = $ID";
                        
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
                echo "<strong>" . $row['ma_name'] . "</strong><br>";
                echo "<hr>";
                echo "<div class='row'><div class='col-sm-6 col-lg-4'>Beskrivning </div><div class='col-sm-6 col-lg-4'>" . $row['ma_description'] . "<div class='col-auto'></div></div></div>";        
            
                echo "<hr>";

                echo "
                <div class='form-group'>
                    <div class='row'>
                        <div class='col'>
                            <button type='button' class='btn btn-primary' title='Stäng'>Stäng</button>                  
                        </div>";
                        if ($_SESSION['user_role'] == 2) {
                            echo "<div class='col'>";
                            echo "<button class='btn btn-success' id='btn-edit-material' maid='" . $row['ma_ID'] . "' title='Redigera'>Redigera</button>";
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

    // material edit button click listener
    $(document).on("click", "#btn-edit-material", function() {
        var id = $(this).attr('maid');
        $("#page-content").load('content/page_editmaterial.php?id=' + id, true);
    });
</script>