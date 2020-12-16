<?php
session_start();
require_once("../dbconnect.php");

global $db;


$company = $_SESSION['user_company_ID'];

$sql = "SELECT
            a.pr_ID,
            a.pr_internID,
            a.pr_name,
            a.pr_startdate,
            a.pr_enddate,
            b.st_hex,
            b.st_name
        FROM
            tbl_project a
        LEFT JOIN tbl_status b ON
            a.pr_status = b.st_ID
        WHERE
            a.pr_companyID = $company";

$result = mysqli_query($db, $sql);

// print error message if something happend
if (!$result) {
    printf("Error: %s\n", mysqli_error($db));
    exit();
}

$count = mysqli_num_rows($result);

if ($count > 0) {
    while ($row = mysqli_fetch_array($result)) {            
        echo "<tr>";
        echo "<td scope='col' class='h5'><a href='http://' class='text-dark'>" . ucfirst($row["pr_name"]) . "</a></td>";
        echo "<td scope='col' class='text-center small'>" . $row["pr_internID"] . "</td>";
        echo "<td scope='col'>" . $row["pr_startdate"] . " -- " . $row["pr_enddate"] . "</td>";        
        echo "<td scope='col' style='background-color: #" . $row["st_hex"] . ";' class='text-center'>" . $row["st_name"] . "</div></td>";
        echo "<td scope='col'></td>";
        echo "</tr>";
    }
    
}    
return $result;
// free sql result    
mysqli_free_result($result);       
// close connection
$db-> close(); 
?>