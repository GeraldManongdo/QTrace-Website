<?php
// Database connection
require('../connection/connection.php');
require('audit_service.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Capture Data from "Project Information" & "Location"
    $contractor_id   = (int)$_POST['Contractor_ID'];
    $project_status  = $conn->real_escape_string($_POST['Project_Status']);
    $project_lng     = $conn->real_escape_string($_POST['lng']);
    $project_lat     = $conn->real_escape_string($_POST['lat']);

    // 2. Capture Data from "Budget & Timeline"
    $project_title       = $conn->real_escape_string($_POST['Project_Title']);
    $project_description = $conn->real_escape_string($_POST['Project_Description']);
    $project_budget      = (float)$_POST['Project_Budget'];
    $street              = $conn->real_escape_string($_POST['street']);
    $barangay            = $conn->real_escape_string($_POST['barangay']);
    $zip_code            = $conn->real_escape_string($_POST['zip_code']);
    $started_date        = $_POST['Project_StartedDate'];
    $end_date            = $_POST['Project_EndDate'];
    $project_category     = $conn->real_escape_string($_POST['Project_Category']);

    // Begin Transaction
    $conn->begin_transaction();

    try {
        // --- STEP 1: Insert into projects_table ---
        $sql1 = "INSERT INTO projects_table (
                    Contractor_ID, 
                    Project_Status, 
                    Project_Lng, 
                    Project_Lat,
                    Project_Category
                ) VALUES (?, ?, ?, ?, ?)";
        
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("issss", $contractor_id, $project_status, $project_lng, $project_lat, $project_category);
        $stmt1->execute();
        $project_id = $conn->insert_id;

        // --- STEP 2: Insert into projectdetails_table ---
        $sql2 = "INSERT INTO projectdetails_table (
                    Project_ID, 
                    ProjectDetails_Title, 
                    ProjectDetails_Description, 
                    ProjectDetails_Budget, 
                    ProjectDetails_Street, 
                    ProjectDetails_Barangay, 
                    ProjectDetails_ZIP_Code, 
                    ProjectDetails_StartedDate, 
                    ProjectDetails_EndDate
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("issdsssss", 
            $project_id, $project_title, $project_description, 
            $project_budget, $street, $barangay, $zip_code, 
            $started_date, $end_date
        );
        $stmt2->execute();

        // --- STEP 3: Handle Legal Documents (projectsdocument_table) ---
        if (!empty($_FILES['document_files']['name'][0])) {
            $docDir = $_SERVER['DOCUMENT_ROOT'] . "/QTrace-Website/uploads/projects/documents/";
            if (!is_dir($docDir)) mkdir($docDir, 0777, true);

            $stmtDoc = $conn->prepare("INSERT INTO projectsdocument_table (
                                        Project_ID, 
                                        ProjectDocument_FileLocation, 
                                        ProjectDocument_Type
                                        ) VALUES (?, ?, ?)");

            foreach ($_FILES['document_files']['name'] as $key => $val) {
                if ($_FILES['document_files']['error'][$key] == 0) {
                    $docName = $_POST['document_names'][$key];
                    $tmpPath = $_FILES['document_files']['tmp_name'][$key];
                    $ext     = pathinfo($val, PATHINFO_EXTENSION);
                    
                    // Generate unique filename to prevent overwriting
                    $filename = "DOC_" . $project_id . "_" . time() . "_" . $key . "." . $ext;
                    $serverPath = $docDir . $filename;
                    $webPath = "/QTrace-Website/uploads/projects/documents/" . $filename;

                    if (move_uploaded_file($tmpPath, $serverPath)) {
                        $stmtDoc->bind_param("iss", $project_id, $webPath, $docName);
                        $stmtDoc->execute();
                    }
                }
            }
        }

        // --- STEP 4: Handle Milestone Gallery (projectmilestone_table) ---
        $imgTypes = $_POST['img_types'] ?? [];
        $imgUrls  = $_POST['img_urls'] ?? [];
        $imgFiles = $_FILES['img_files'] ?? ['name' => [], 'tmp_name' => [], 'error' => []];

        if (!empty($imgTypes)) {
            $imgDir = $_SERVER['DOCUMENT_ROOT'] . "/QTrace-Website/uploads/projects/milestones/";
            $stmtMilestone = $conn->prepare("INSERT INTO projectmilestone_table (
                                                Project_ID, 
                                                projectMilestone_Image_Path, 
                                                projectMilestone_Phase
                                                ) VALUES (?, ?, ?)");

            foreach ($imgTypes as $key => $phaseRaw) {
                $phase = $conn->real_escape_string($phaseRaw);
                $webPath = null;

                $hasFile = isset($imgFiles['error'][$key]) && $imgFiles['error'][$key] == 0 && !empty($imgFiles['tmp_name'][$key]);
                $urlInput = trim($imgUrls[$key] ?? '');
                $hasUrl = $urlInput && filter_var($urlInput, FILTER_VALIDATE_URL);

                if ($hasFile) {
                    if (!is_dir($imgDir)) mkdir($imgDir, 0777, true);
                    $val = $imgFiles['name'][$key];
                    $tmpPath = $imgFiles['tmp_name'][$key];
                    $ext = pathinfo($val, PATHINFO_EXTENSION);

                    $filename = "IMG_" . $project_id . "_" . time() . "_" . $key . "." . $ext;
                    $serverPath = $imgDir . $filename;
                    $webPath = "/QTrace-Website/uploads/projects/milestones/" . $filename;

                    if (!move_uploaded_file($tmpPath, $serverPath)) {
                        $webPath = null;
                    }
                } elseif ($hasUrl) {
                    $webPath = $urlInput;
                }

                if ($webPath) {
                    $stmtMilestone->bind_param("iss", $project_id, $webPath, $phase);
                    $stmtMilestone->execute();
                }
            }
        }

        // Commit all changes if everything is successful
        $conn->commit();

        // --- LOG AUDIT ACTIVITY ---
        $auditService = new AuditService($conn);
        $userId = $_SESSION['user_ID'] ?? null;
        
        // Prepare new values for audit log
        $newProjectVals = [
            'Contractor_ID' => $contractor_id,
            'Project_Status' => $project_status,
            'Project_Category' => $project_category,
            'Project_Title' => $project_title,
            'Project_Description' => $project_description,
            'Project_Budget' => $project_budget,
            'Location' => "$street, $barangay, $zip_code",
            'Started_Date' => $started_date,
            'End_Date' => $end_date
        ];
        
        $auditService->log($userId, 'CREATE', 'Project', $project_id, null, $newProjectVals);

        $msg = urlencode("Project added successfully.");
        header("Location: /QTrace-Website/project-list?status=success&msg=$msg");
        exit();

    } catch (Exception $e) {
        // Rollback transaction if any error occurs to prevent partial data
        $conn->rollback();
        die("Error processing request: " . $e->getMessage());
    }
}
?>