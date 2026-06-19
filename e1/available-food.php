<?php
require_once 'includes/config.php';
include 'includes/header.php';

$sql = "SELECT d.*, u.name as donor_name FROM donations d JOIN users u ON d.user_id = u.id WHERE d.status = 'available' ORDER BY d.created_at DESC";
$result = $conn->query($sql);
?>

<div class="bg-success text-white py-5 mb-5">
    <div class="container text-center">
        <h1 class="fw-bold">Available Food Donations</h1>
        <p class="lead">Help us ensure this food reaches those in need.</p>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="uploads/<?php echo $row['image'] ?: 'food-placeholder.jpg'; ?>" class="card-img-top" height="200" style="object-fit: cover;">
                        <div class="card-body">
                            <h5 class="fw-bold"><?php echo $row['food_name']; ?></h5>
                            <p class="text-muted small mb-3"><?php echo substr($row['description'], 0, 100); ?>...</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-success"><?php echo $row['category']; ?></span>
                                <span class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i> <?php echo substr($row['pickup_address'], 0, 20); ?>...</span>
                            </div>
                            <hr>
                            <a href="login.php" class="btn btn-outline-success w-100">Request This Food</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <h3>No active donations found.</h3>
                <p class="text-muted">Be the change! <a href="register.php?role=donor">Start donating today.</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
