<?php
include 'config/db.php';
include 'header.php';

$searchResults = [];
$error = "";

// Handle File Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['search_image'])) {
    $targetDir = "uploads/search/";
    
    // Create folder if it doesn't exist
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($_FILES["search_image"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $fileName; // Unique name
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'webp');
    if (in_array(strtolower($fileType), $allowTypes)) {
        // Upload file to server
        if (move_uploaded_file($_FILES["search_image"]["tmp_name"], $targetFilePath)) {
            
            // --- CALL PYTHON SCRIPT ---
            // command: python ml/image_search.py "path/to/image"
            // Note: If 'python' doesn't work, try full path e.g. "C:\\Python39\\python.exe"
            $command = 'python ml/image_search.py "' . $targetFilePath . '" 2>&1';
            $output = shell_exec($command);
            
            // Decode JSON response from Python
            $matches = json_decode($output, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($matches)) {
                // If we got matches, fetch product details from DB
                foreach ($matches as $match) {
                    $imgName = $match['image'];
                    // SQL: Find product with this image name
                    // NOTE: Adjust column name 'image' if your DB uses 'product_image'
                    $stmt = $conn->prepare("SELECT * FROM products WHERE image LIKE ? OR image = ?");
                    $likeName = "%".$imgName; 
                    $stmt->bind_param("ss", $likeName, $imgName);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($row = $result->fetch_assoc()) {
                        // Add similarity score to the row for display
                        $row['similarity'] = round($match['score'] * 100, 1); 
                        $searchResults[] = $row;
                    }
                }
            } else {
                $error = "AI Error: " . htmlspecialchars($output); 
            }

        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    } else {
        $error = "Sorry, only JPG, JPEG, PNG & WEBP files are allowed.";
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">AI Visual Search</h2>
    
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body text-center">
                    <form action="image_search.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload a photo to find similar clothes:</label>
                            <input type="file" name="search_image" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </form>
                    <?php if($error): ?>
                        <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($searchResults)): ?>
    <div class="mt-5">
        <h3>Top Matches</h3>
        <div class="row">
            <?php foreach ($searchResults as $product): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="uploads/products/<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text text-muted">Match: <?php echo $product['similarity']; ?>%</p>
                        <p class="card-text fw-bold">$<?php echo $product['price']; ?></p>
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-primary btn-sm">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && !$error): ?>
        <div class="alert alert-warning mt-4 text-center">No similar products found.</div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>