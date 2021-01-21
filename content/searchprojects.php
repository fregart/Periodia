<?php
session_start();
require_once("../dbconnect.php");
require_once("../functions.php");

global $db;

$str_get = $_GET['q'];
$str = $db->real_escape_string($str_get);

$company = $_SESSION['user_company_ID'];

if ($str_get == "getAll") {    
    $sql = "SELECT
        *
    FROM
        tbl_project
    LEFT JOIN tbl_status b ON
        b.st_ID = tbl_project.pr_status 
        WHERE pr_status NOT LIKE 5
    AND tbl_project.pr_companyID = $company ORDER BY tbl_project.pr_name ASC";
}else {
    $sql = "SELECT
        *
    FROM
        (
        SELECT
            *
        FROM
            tbl_project
        WHERE
            tbl_project.pr_companyID = $company
    ) a
    LEFT JOIN tbl_status b ON
        b.st_ID = a.pr_status        
    WHERE
        a.pr_name LIKE '%$str%' OR a.pr_internID LIKE '%$str%' OR a.pr_startdate LIKE '%$str%' OR a.pr_enddate LIKE '%$str%' OR b.st_name LIKE '%$str%'";
}

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
        echo "<td scope='col' class='h5' style='border-left:1rem solid #" . $row["st_hex"] . ";'><div class='list-project'><a href='#' class='text-dark' myID='" . $row["pr_ID"] . "'>" . ucfirst($row["pr_name"]) . "</a>" . "<div class='d-none d-sm-block d-md-block d-lg-none small'>" . $row["pr_internID"] . "</div>" . "</div></td>";        
        echo "<td scope='col' class='d-none d-lg-table-cell text-center small'>". $row["pr_internID"] . "</td>";
            // format date for start date
            $string_start = $row["pr_startdate"];
            $timestamp_start = strtotime($string_start);
            $yearnr_start = date("Y", $timestamp_start);
            $monthnr_start = date("m", $timestamp_start);
            $daynr_start = date("d", $timestamp_start);

            // format date for end date if exist
            if (!$row["pr_enddate"] == null) {
                $string_end = $row["pr_enddate"]; 
                $timestamp_end = strtotime($string_end);
                $yearnr_end = date("Y", $timestamp_end);
                $monthnr_end = date("m", $timestamp_end);
                $daynr_end = date("d", $timestamp_end);

                echo "<td scope='col'>". $yearnr_start . " " . getMonthName($monthnr_start) . " ". $daynr_start ." -- ". $yearnr_end . " " . getMonthName($monthnr_end) . " ". $daynr_end ."</td>";        
            }else {
                echo "<td scope='col'>". $yearnr_start . " " . getMonthName($monthnr_start) . " ". $daynr_start ." -- </td>";        
            }
                    
        echo "<td scope='col' class='d-none d-lg-table-cell h6 text-center align-middle' style='background-color: #" . $row["st_hex"] . ";color:#ffffff;'>" . $row["st_name"] . "</div></td>";        
        echo "</tr>";
    }
    
}
return $result;
// free sql result    
mysqli_free_result($result);       
// close connection
$db-> close(); 
?>