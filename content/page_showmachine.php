<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>
<?php 

$machineID= intval($_GET['id']);

global $db;

$sql = "SELECT *
FROM tbl_machine a    
WHERE a.ma_ID = $machineID";
                        
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
                echo "<strong>" . $row['ma_name'] . " " . $row['ma_regnr'] . "</strong><br>";
                echo "<hr>";
                echo "<div class='row'><div class='col-4'>Reg. nr. </div><div class='col-4'>" . $row['ma_regnr'] . "<div class='col-auto'></div></div></div>";
                echo "<hr>";
                echo "<div class='row'><div class='col-4'>Mätarställning </div><div class='col-4'>" . $row['ma_mileage'] . "<div class='col-auto'></div></div></div>";
                echo "<hr>";
                echo "<div class='row'><div class='col-4'>Arbetstimmar </div><div class='col-4'>" . $row['ma_hours'] . "<div class='col-auto'></div></div></div>";
                echo "<hr>";
                echo "<div class='row'><div class='col-4'>Beskrivning </div><div class='col-4'>" . $row['ma_description'] . "<div class='col-auto'></div></div></div>";        
            echo "</div>";
        echo "</div>";
    }
   
    echo "</div>";
}