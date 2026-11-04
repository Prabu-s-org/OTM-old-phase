<?php
// Example DB Connection (Update with your credentials)
$pdo = new PDO("mysql:host=localhost;dbname=operation_team_beta", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['district_name'])) {
        $selectedValues = $_POST['district_name']; // Get selected values as an array
        $storedValue = implode(",", $selectedValues); // Convert array to comma-separated string

        // Store in database (Adjust table/column as needed)
        $stmt = $pdo->prepare("INSERT INTO district_data (districts) VALUES (:districts)");
        $stmt->bindParam(':districts', $storedValue);
        $stmt->execute();

        // Store message to display after refresh
        $message = "Data stored successfully: " . $storedValue;
    } else {
        $message = "No values selected!";
    }
}

// Fetch stored values to display
$stmt = $pdo->query("SELECT districts FROM your_table ORDER BY id DESC LIMIT 1");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$selectedValues = isset($row['districts']) ? explode(",", $row['districts']) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Select Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2>Select Multiple Districts</h2>

    <?php if (isset($message)) : ?>
        <div class="alert alert-info"><?= $message; ?></div>
    <?php endif; ?>

    <form method="POST">
        <select class="selectpicker form-control" name="district_name[]" multiple data-live-search="true">
            <option value="Mustard" <?= in_array('Mustard', $selectedValues) ? 'selected' : '' ?>>Mustard</option>
            <option value="Ketchup" <?= in_array('Ketchup', $selectedValues) ? 'selected' : '' ?>>Ketchup</option>
            <option value="Relish" <?= in_array('Relish', $selectedValues) ? 'selected' : '' ?>>Relish</option>
        </select>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>

</div>

</body>
</html>

