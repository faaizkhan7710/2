<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('volunteer');

$user_id = $_SESSION['user_id'];

// Handle Task Claiming
if (isset($_POST['claim_task'])) {
    $delivery_id = (int)$_POST['delivery_id'];
    $conn->query("UPDATE deliveries SET volunteer_id = $user_id, status = 'assigned' WHERE id = $delivery_id");
    $success = "Task claimed successfully!";
}

include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-4">Available Pickup Tasks</h2>

            <?php if(isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <div class="row">
                <?php
                $sql = "SELECT del.*, d.food_name, d.pickup_address, d.quantity, u.name as donor_name 
                        FROM deliveries del 
                        JOIN donations d ON del.donation_id = d.id 
                        JOIN users u ON d.user_id = u.id 
                        WHERE del.volunteer_id IS NULL AND del.status = 'assigned'
                        ORDER BY del.id DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0):
                    while($row = $result->fetch_assoc()):
                ?>
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold mb-1"><?php echo $row['food_name']; ?></h5>
                                    <span class="badge bg-light text-dark"><?php echo $row['quantity']; ?></span>
                                </div>
                                <span class="badge bg-success">Ready for Pickup</span>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1 small text-muted fw-bold text-uppercase">Pickup From:</p>
                                <p class="mb-0 small"><i class="fas fa-user me-2 text-success"></i> <?php echo $row['donor_name']; ?></p>
                                <p class="mb-0 small"><i class="fas fa-map-marker-alt me-2 text-danger"></i> <?php echo $row['pickup_address']; ?></p>
                            </div>
                            <form action="" method="POST">
                                <input type="hidden" name="delivery_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="claim_task" class="btn btn-success w-100 fw-bold">Claim Task</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php 
                    endwhile;
                else:
                ?>
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted">No unassigned tasks available.</h4>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
