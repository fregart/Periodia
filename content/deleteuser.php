<?php
    require_once("../dbconnect.php");

    // set global db variable from dbconnect
    global $db;

    $userID= intval($_GET['q']);

    $stmt = $db->prepare("DELETE FROM tbl_user WHERE us_ID = ?");
    $stmt->bind_param('i', $userID);

    if ($stmt !== false) {
        $stmt->execute();        
        $stmt->close();
        $db->close();

        echo "  
            <script>$(document).ready(function(){
                alert('Användaren har tagits bort');
                    $('#page-content').load('content/page_inställningar.php');                       
                });                        
            </script>
        ";
    } else {
        die('prepare() failed: ' . htmlspecialchars($db->error));
    }
?>