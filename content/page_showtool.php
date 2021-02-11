<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>
<?php 

$ID= intval($_GET['id']);

global $db;

$sql = "SELECT *
FROM tbl_tools a    
WHERE a.to_ID = $ID";
                        
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
                echo "<strong>" . $row['to_name'] . "</strong><br>";
                echo "<hr>";
                echo "<div class='row text-nowrap'><div class='col-sm-6 col-lg-4'>Beskrivning </div><div class='col-sm-6 col-lg-4'>" . $row['to_description'] . "<div class='col-auto'></div></div></div>";        
            echo "</div>";
        echo "</div>";
    }
   
    echo "</div>";
}