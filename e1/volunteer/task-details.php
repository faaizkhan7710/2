<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('volunteer');

$user_id = $_SESSION['user_id'];
$delivery_id = (int)$_GET['id'];

// Fetch task details
$sql = "SELECT del.*, d.food_name, d.pickup_address, d.quantity, u.name as donor_name, u.phone as donor_phone, 
        ngo.name as ngo_name, ngo.address as ngo_address, ngo.phone as ngo_phone
        FROM deliveries del 
        JOIN donations d ON del.donation_id = d.id 
        JOIN users u ON d.user_id = u.id 
        JOIN requests r ON d.id = r.donation_id AND r.status = 'accepted'
        JOIN users ngo ON r.ngo_id = ngo.id
        WHERE del.id = $delivery_id AND del.volunteer_id = $user_id";
$task = $conn->query($sql)->fetch_assoc();

if (!$task) redirect('dashboard.php');

// Handle status updates
if (isset($_POST['update_status'])) {
    $new_status = $_POST['status'];
    $now = date('Y-m-d H:i:s');
    
    if ($new_status == 'picked_up') {
        $conn->query("UPDATE deliveries SET status = 'picked_up', pickup_time = '$now' WHERE id = $delivery_id");
        $conn->query("UPDATE donations SET status = 'picked_up' WHERE id = {$task['donation_id']}");
    } else if ($new_status == 'delivered') {
        $conn->query("UPDATE deliveries SET status = 'delivered', delivery_time = '$now' WHERE id = $delivery_id");
        $conn->query("UPDATE donations SET status = 'delivered' WHERE id = {$task['donation_id']}");
        $conn->query("UPDATE requests SET status = 'completed' WHERE donation_id = {$task['donation_id']}");
        
        // Award points to volunteer
        $conn->query("UPDATE users SET points = points + 20 WHERE id = $user_id");
        
        // Update global impact
        updateImpact(5, 2, 1); // Mock values: 5 meals, 2kg food, 1 family
    }
    redirect("task-details.php?id=$delivery_id");
}

include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-4">Task Details</h2>

            <div class="row">
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold mb-0"><?php echo $task['food_name']; ?></h4>
                                <span class="badge bg-info p-2"><?php echo ucfirst($task['status']); ?></span>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-6 border-end">
                                    <p class="text-muted small mb-1">PICKUP FROM</p>
                                    <h6 class="fw-bold"><?php echo $task['donor_name']; ?></h6>
                                    <p class="small mb-1 text-muted"><i class="fas fa-phone me-1"></i> <?php echo $task['donor_phone']; ?></p>
                                    <p class="small mb-0 text-muted"><i class="fas fa-map-marker-alt me-1"></i> <?php echo $task['pickup_address']; ?></p>
                                </div>
                                <div class="col-6 ps-4">
                                    <p class="text-muted small mb-1">DELIVER TO</p>
                                    <h6 class="fw-bold"><?php echo $task['ngo_name']; ?></h6>
                                    <p class="small mb-1 text-muted"><i class="fas fa-phone me-1"></i> <?php echo $task['ngo_phone']; ?></p>
                                    <p class="small mb-0 text-muted"><i class="fas fa-map-marker-alt me-1"></i> <?php echo $task['ngo_address']; ?></p>
                                </div>
                            </div>

                            <hr>

                            <form action="" method="POST" class="mt-4">
                                <?php if($task['status'] == 'assigned'): ?>
                                    <input type="hidden" name="status" value="picked_up">
                                    <button type="submit" name="update_status" class="btn btn-primary btn-lg w-100 fw-bold">Mark as Picked Up</button>
                                <?php elseif($task['status'] == 'picked_up'): ?>
                                    <input type="hidden" name="status" value="delivered">
                                    <button type="submit" name="update_status" class="btn btn-success btn-lg w-100 fw-bold">Mark as Delivered</button>
                                <?php else: ?>
                                    <div class="alert alert-success text-center">
                                        <i class="fas fa-check-circle fa-2x mb-2 d-block"></i>
                                        Task Completed Successfully!
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white fw-bold py-3">Route Map</div>
                        <div class="card-body p-0">
                            <!-- Mock Google Map -->
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                                <div class="text-center text-muted">
                                    <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
                                    <p>Interactive Map View<br><small>(Google Maps API Integration)</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
