<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('donor');

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_donation'])) {
    $user_id = $_SESSION['user_id'];
    $food_name = sanitize($_POST['food_name']);
    $category = sanitize($_POST['category']);
    $quantity = sanitize($_POST['quantity']);
    $description = sanitize($_POST['description']);
    $pickup_address = sanitize($_POST['pickup_address']);
    $prep_time = $_POST['preparation_time'];
    $expiry_time = $_POST['expiry_time'];

    // Handle Image Upload
    $image_name = '';
    if (isset($_FILES['food_image']) && $_FILES['food_image']['error'] == 0) {
        $target_dir = "../uploads/";
        $image_name = time() . "_" . basename($_FILES["food_image"]["name"]);
        $target_file = $target_dir . $image_name;
        move_uploaded_file($_FILES["food_image"]["tmp_name"], $target_file);
    }

    // Calculate Freshness Score
    $now = new DateTime();
    $prep = new DateTime($prep_time);
    $exp = new DateTime($expiry_time);
    
    $total_life = $exp->getTimestamp() - $prep->getTimestamp();
    $elapsed = $now->getTimestamp() - $prep->getTimestamp();
    
    if ($total_life > 0) {
        $freshness_score = max(0, min(100, round(100 - ($elapsed / $total_life * 100))));
    } else {
        $freshness_score = 0;
    }

    $sql = "INSERT INTO donations (user_id, food_name, category, quantity, description, pickup_address, preparation_time, expiry_time, image, freshness_score) 
            VALUES ('$user_id', '$food_name', '$category', '$quantity', '$description', '$pickup_address', '$prep_time', '$expiry_time', '$image_name', '$freshness_score')";
    
    if ($conn->query($sql)) {
        // Award points to donor
        $conn->query("UPDATE users SET points = points + 10 WHERE id = $user_id");
        $success = "Donation posted successfully! You earned 10 reward points.";
    } else {
        $error = "Error: " . $conn->error;
    }
}

include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-4">Post New Food Donation</h2>

            <div class="card border-0 shadow-sm col-lg-8">
                <div class="card-body p-4">
                    <?php if($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Food Name</label>
                                <input type="text" name="food_name" class="form-control" placeholder="e.g. Biryani, Bread, Vegetables" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="Cooked Food">Cooked Food</option>
                                    <option value="Bakery Items">Bakery Items</option>
                                    <option value="Vegetables/Fruits">Vegetables/Fruits</option>
                                    <option value="Packaged Food">Packaged Food</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="text" name="quantity" class="form-control" placeholder="e.g. 5 KG, 10 Plates" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Food Image</label>
                                <input type="file" name="food_image" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pickup Address</label>
                            <textarea name="pickup_address" class="form-control" rows="2" placeholder="Exact location for pickup" required><?php echo $_SESSION['address'] ?? ''; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Add any special instructions or details about the food"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Preparation Time</label>
                                <input type="datetime-local" name="preparation_time" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Expiry Time</label>
                                <input type="datetime-local" name="expiry_time" class="form-control" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" name="submit_donation" class="btn btn-success btn-lg w-100 fw-bold py-2">Post Donation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
