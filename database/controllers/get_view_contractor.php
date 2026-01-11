<?php
require('../../database/connection/connection.php');

// Validate ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: contractor_list.php");
    exit();
}

$contractor_id = (int)$_GET['id'];

// 2. Fetch Main Contractor Data
$sql = "SELECT * 
        FROM contractor_table 
        WHERE Contractor_Id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $contractor_id);
$stmt->execute();
$contractor = $stmt->get_result()->fetch_assoc();

if (!$contractor) {
    die("Contractor not found.");
}

// 3. Fetch Expertise
$sql_exp = "SELECT Expertise 
            FROM contractor_expertise_table 
            WHERE Contractor_Id = ?";
$stmt_exp = $conn->prepare($sql_exp);
$stmt_exp->bind_param("i", $contractor_id);
$stmt_exp->execute();
$expertise_res = $stmt_exp->get_result();

// 4. Fetch Documents
$sql_doc = "SELECT Document_Type, Document_Path 
            FROM contractor_documents_table 
            WHERE Contractor_Id = ?";
$stmt_doc = $conn->prepare($sql_doc);
$stmt_doc->bind_param("i", $contractor_id);
$stmt_doc->execute();
$documents_res = $stmt_doc->get_result();
?>