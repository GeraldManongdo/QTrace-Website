<?php
require('../../database/connection/connection.php');

// Get Count of Active Projects
$sql_active = "SELECT COUNT(*) as total FROM projects_table WHERE Project_Status = 'Planned' || Project_Status = 'Ongoing' || Project_Status = 'Delayed'";
$result_active = $conn->query($sql_active);
$row_active = $result_active->fetch_assoc();
$active_count = $row_active['total'];

// Get Count of Completed Projects
$sql_completed = "SELECT COUNT(*) as total FROM projects_table WHERE Project_Status = 'Completed'";
$result_completed = $conn->query($sql_completed);
$row_completed = $result_completed->fetch_assoc();
$completed_count = $row_completed['total'];

//Get Registered Citizens Count
$query3 = "SELECT COUNT(*) as total FROM user_table";
$result3 = $conn->query($query3);
$citizens_count = $result3->fetch_assoc()['total'];

// Get Count of Resolved Reports
$sql_reports = "SELECT COUNT(*) as total FROM report_table WHERE report_status = 'Resolved'";
$result_reports = $conn->query($sql_reports);
$row_reports = $result_reports->fetch_assoc();
$resolved_count = $row_reports['total'];

// Get Count of Total Reports
$query_total = "SELECT COUNT(*) as total FROM report_table";
$total_reports = $conn->query($query_total)->fetch_assoc()['total'];

// Calculate % (Avoid division by zero error)
if ($total_reports > 0) {
    $percentage = ($resolved_count / $total_reports) * 100;
    $percentage = number_format($percentage, 0); // Remove decimal places
} else {
    $percentage = 0;
}
?>