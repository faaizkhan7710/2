<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('ngo');

$user_id = $_SESSION['user_id'];

// Handle Request
if (isset($_POST['request_food'])) {
    $donation_id = (int)$_POST['donation_id'];
    
    // Check if already requested
    $check = $conn->query("SELECT id FROM requests WHERE donation_id = $donation_id AND ngo_id = $user_id");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO requests (donation_id, ngo_id, status) VALUES ($donation_id, $user_id, 'pending')");
        $conn->query("UPDATE donations SET status = 'requested' WHERE id = $donation_id");
        $success = "Request sent successfully!";
    } else {
        $error = "You have already requested this item.";
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
            <h2 class="fw-bold mb-4">Available Food Donations</h2>

            <?php if(isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="row">
                <?php
                $sql = "SELECT d.*, u.name as donor_name 
                        FROM donations d 
                        JOIN users u ON d.user_id = u.id 
                        WHERE d.status = 'available' 
                        ORDER BY d.freshness_score DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0):
                    while($row = $result->fetch_assoc()):
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden">
                        <div class="position-relative">
                            <img src="../uploads/<?php echo $row['image'] ?: 'food-placeholder.jpg'; ?>" class="card-img-top" height="200" style="object-fit: cover;">
                            <div class="position-absolute top-0 end-0 p-2">
                                <span class="badge <?php echo $row['freshness_score'] > 70 ? 'bg-success' : ($row['freshness_score'] > 40 ? 'bg-warning' : 'bg-danger'); ?>">
                                    <?php echo $row['freshness_score']; ?>% Fresh
                                </span>
                            </div>
                            <?php if ($row['freshness_score'] < 30): ?>
                                <div class="position-absolute bottom-0 start-0 p-2 w-100 bg-danger text-white text-center small fw-bold">
                                    <i class="fas fa-exclamation-triangle me-1"></i> URGENT PICKUP NEEDED
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-success small fw-bold"><?php echo $row['category']; ?></span>
                                <span class="text-muted small"><i class="fas fa-weight me-1"></i><?php echo $row['quantity']; ?></span>
                            </div>
                            <h5 class="fw-bold mb-2"><?php echo $row['food_name']; ?></h5>
                            <p class="text-muted small mb-3"><?php echo substr($row['description'], 0, 80); ?>...</p>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-user-circle text-muted me-2"></i>
                                <span class="small text-muted"><?php echo $row['donor_name']; ?></span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                <span class="small text-muted"><?php echo substr($row['pickup_address'], 0, 40); ?>...</span>
                            </div>
                            <form action="" method="POST">
                                <input type="hidden" name="donation_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="request_food" class="btn btn-success w-100 fw-bold">Request Food</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php 
                    endwhile;
                else:
                ?>
                <div class="col-12 text-center py-5">
                    <img src="../assets/images/no-food.svg" width="200" class="mb-4 opacity-50">
                    <h4 class="text-muted">No food donations available right now.</h4>
                    <p class="text-muted">Check back later or enable notifications.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
