<?php
include '../config/db.php';
include '../config/auth.php';

// Ensure only admin can access
if (function_exists('adminOnly')) {
    adminOnly();
}

include '../header.php'; // Keep the admin UI consistent
?>

<div class="container-fluid p-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">AI Knowledge Update</h4>
        </div>
        <div class="card-body">
            <p>Running the neural network updater...</p>
            
            <?php
            // 1. Define the safe absolute path to the Python script
            // __DIR__ gives us "C:\xampp\htdocs\smart_ai_clothing\admin"
            $scriptPath = realpath(__DIR__ . '/../ml/generate_vectors.py');
            
            // 2. Prepare command (2>&1 captures errors too)
            // Note: If 'python' is not found, try replacing with full path e.g. "C:\\Python39\\python.exe"
            $command = "python \"$scriptPath\" 2>&1"; 
            
            // 3. Execute
            $output = shell_exec($command);
            ?>

            <h5>Result Log:</h5>
            <pre class="bg-dark text-light p-3 rounded" style="max-height: 400px; overflow-y: auto;"><?php 
                echo $output ? htmlspecialchars($output) : "Error: No output returned. Check your Python installation."; 
            ?></pre>

            <?php if (strpos($output, 'Done!') !== false): ?>
                <div class="alert alert-success mt-3">
                    <strong>Success!</strong> The AI has learned the new products.
                </div>
            <?php else: ?>
                <div class="alert alert-warning mt-3">
                    <strong>Warning:</strong> The script ran, but didn't report "Done". Check the log above for errors.
                </div>
            <?php endif; ?>

            <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
        </div>
    </div>
</div>