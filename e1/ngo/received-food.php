<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('ngo');

$user_id = $_SESSION['user_id'];

$sql = "SELECT r.*, d.food_name, d.category, d.quantity, d.image, d.pickup_address, u.name as donor_name 
        FROM requests r 
        JOIN donations d ON r.donation_id = d.id 
        JOIN users u ON d.user_id = u.id 
        WHERE r.ngo_id = $user_id AND r.status = 'completed'
        ORDER BY r.requested_at DESC";
$result = $conn->query($sql);

include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-4">Received Food</h2>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">
                    All Received Deliveries
                </div>
                <div class="card-body">
                    <?php if ($result->num_rows > 0): ?>
                        <div class="row">
                            <?php while($row = $result->fetch_assoc()): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border shadow-none">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="../uploads/<?php echo $row['image'] ?: 'food-placeholder.jpg'; ?>" class="img-fluid rounded-start h-100" style="object-fit: cover;">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h6 class="fw-bold mb-1"><?php echo $row['food_name']; ?></h6>
                                                <p class="text-muted small mb-1"><i class="fas fa-tag me-1"></i> <?php echo $row['category']; ?></p>
                                                <p class="text-muted small mb-1"><i class="fas fa-sort-amount-down me-1"></i> Qty: <?php echo $row['quantity']; ?></p>
                                                <p class="text-muted small mb-1"><i class="fas fa-user me-1"></i> Donor: <?php echo $row['donor_name']; ?></p>
                                                <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt me-1"></i> <?php echo $row['pickup_address']; ?></p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Received</span>
                                                    <small class="text-muted"><?php echo date('M d, Y', strtotime($row['requested_at'])); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-4x mb-3"></i>
                            <h5>No food received yet</h5>
                            <p>You haven't received any food deliveries yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>