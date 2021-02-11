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
    echo "<div class='container'>";
    
    while($row = mysqli_fetch_array($result)) {
        echo "<div class='card'>";
            echo "<div class='card-body'>";
                echo "<strong>" . $row['ve_name'] . " " . $row['ve_regnr'] . "</strong><br>";
                echo "<div class='row text-nowrap'><div class='col-sm-6 col-lg-4'>Reg. nr. </div><div class='col-sm-6 col-lg-4'>" . $row['ve_regnr'] . "<div class='col-auto'></div></div></div>";
                echo "<hr>";
                echo "<div class='row text-nowrap'><div class='col-sm-6 col-lg-4'>Mätarställning </div><div class='col-sm-6 col-lg-4'>" . $row['ve_mileage'] . "<div class='col-auto'></div></div></div>";
                echo "<hr>";
                echo "<div class='row'><div class='col-sm-6 col-lg-4'>Beskrivning <p></p></div><div class='col-sm-6 col-lg-4'>" . $row['ve_description'] . "<div class='col-auto'></div></div></div>";        
            echo "</div>";
        echo "</div>";
    }
   
    echo "</div>";
}