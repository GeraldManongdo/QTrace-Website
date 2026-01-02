<?php
// 1. DATABASE CONNECTION
$host = "localhost";
$user = "root";
$pass = "";
$db   = "qtrace";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. PROCESSING THE FORM
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // For testing purposes, we assume a Contractor ID
    // In your real app, this might come from a session or a previous INSERT
    $contractor_id = 1; 

    if (!empty($_POST['expertise']) && is_array($_POST['expertise'])) {
        
        $stmtEx = $conn->prepare("INSERT INTO contractor_expertise_table (Contractor_Id, Expertise) VALUES (?, ?)");
        
        $count = 0;
        foreach ($_POST['expertise'] as $skill) {
            $cleanSkill = trim($skill);
            if ($cleanSkill !== '') {
                $stmtEx->bind_param("is", $contractor_id, $cleanSkill);
                if ($stmtEx->execute()) {
                    $count++;
                }
            }
        }
        $stmtEx->close();
        $message = "<div class='alert alert-success'>Successfully saved $count skills!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contractor Skills</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .animate-fadeIn { animation: fadeIn 0.3s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        body { padding: 50px; background-color: #f8f9fa; }
        .container { max-width: 600px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container">
    <h2>Contractor Expertise</h2>
    <hr>
    
    <?php echo $message; ?>

    <form action="" method="POST">
        <div id="skillWrapper">
            <label class="form-label">Expertise / Skills</label>
            <div class="input-group mb-2">
                <input type="text" name="expertise[]" class="form-control" placeholder="Enter skill" required />
            </div>
        </div>

        <div class="mt-3">
            <button type="button" id="addSkill" class="btn btn-secondary btn-sm">+ Add Another Skill</button>
            <hr>
            <button type="submit" class="btn btn-primary w-100">Save All Skills</button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    // Add new input field
    $("#addSkill").click(function() {
        let field = `
            <div class="input-group mb-2 animate-fadeIn">
                <input type="text" name="expertise[]" class="form-control" placeholder="Enter skill">
                <button class="btn btn-danger remove-row" type="button">Remove</button>
            </div>`;
        $('#skillWrapper').append(field);
    });

    // Remove input field
    $(document).on('click', '.remove-row', function() {
        $(this).closest('.input-group').remove();
    });
});
</script>

</body>
</html>