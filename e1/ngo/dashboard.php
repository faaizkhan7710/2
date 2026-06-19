<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('ngo');

$user_id = $_SESSION['user_id'];

// Get statistics
$total_requests = $conn->query("SELECT COUNT(*) as count FROM requests WHERE ngo_id = $user_id")->fetch_assoc()['count'];
$accepted_requests = $conn->query("SELECT COUNT(*) as count FROM requests WHERE ngo_id = $user_id AND status = 'accepted'")->fetch_assoc()['count'];
$received_meals = $conn->query("SELECT COUNT(*) as count FROM requests WHERE ngo_id = $user_id AND status = 'completed'")->fetch_assoc()['count'];

include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-4">NGO Dashboard</h2>

            <div class="row dashboard-stats mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card p-3 border-0 shadow-sm bg-primary text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-0"><?php echo $total_requests; ?></h3>
                                <small>Total Requests</small>
                            </div>
                            <i class="fas fa-paper-plane"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card p-3 border-0 shadow-sm bg-success text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-0"><?php echo $accepted_requests; ?></h3>
                                <small>Accepted Requests</small>
                            </div>
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card p-3 border-0 shadow-sm bg-info text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-0"><?php echo $received_meals; ?></h3>
                                <small>Meals Received</small>
                            </div>
                            <i class="fas fa-utensils"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white fw-bold py-3 d-flex justify-content-between align-items-center">
                            <span>Available Food Nearby</span>
                            <a href="available-food.php" class="btn btn-sm btn-success">Browse All</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                $available = $conn->query("SELECT d.*, u.name as donor_name FROM donations d JOIN users u ON d.user_id = u.id WHERE d.status = 'available' ORDER BY d.created_at DESC LIMIT 3");
                                if ($available->num_rows > 0):
                                    while($row = $available->fetch_assoc()):
                                ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 border shadow-none">
                                        <img src="../uploads/<?php echo $row['image'] ?: 'food-placeholder.jpg'; ?>" class="card-img-top" height="150" style="object-fit: cover;">
                                        <div class="card-body p-3">
                                            <h6 class="fw-bold mb-1"><?php echo $row['food_name']; ?></h6>
                                            <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt me-1"></i> <?php echo substr($row['pickup_address'], 0, 30); ?>...</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-light text-dark"><?php echo $row['freshness_score']; ?>% Fresh</span>
                                                <a href="view-donation.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                    endwhile;
                                else:
                                    echo "<div class='col-12 text-center py-4 text-muted'>No food available at the moment.</div>";
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
