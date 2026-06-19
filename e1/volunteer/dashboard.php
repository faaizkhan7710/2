<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('volunteer');

$user_id = $_SESSION['user_id'];

// Get statistics
$assigned_tasks = $conn->query("SELECT COUNT(*) as count FROM deliveries WHERE volunteer_id = $user_id AND status != 'delivered'")->fetch_assoc()['count'];
$completed_tasks = $conn->query("SELECT COUNT(*) as count FROM deliveries WHERE volunteer_id = $user_id AND status = 'delivered'")->fetch_assoc()['count'];
$impact_points = $conn->query("SELECT points FROM users WHERE id = $user_id")->fetch_assoc()['points'];

include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-4">Volunteer Dashboard</h2>

            <div class="row dashboard-stats mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card p-3 border-0 shadow-sm bg-primary text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-0"><?php echo $assigned_tasks; ?></h3>
                                <small>Assigned Tasks</small>
                            </div>
                            <i class="fas fa-tasks"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card p-3 border-0 shadow-sm bg-success text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-0"><?php echo $completed_tasks; ?></h3>
                                <small>Completed Deliveries</small>
                            </div>
                            <i class="fas fa-truck-loading"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card p-3 border-0 shadow-sm bg-warning text-dark">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-0"><?php echo $impact_points; ?></h3>
                                <small>Volunteer Points</small>
                            </div>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white fw-bold py-3">Active Tasks</div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">Food Item</th>
                                            <th>Pickup From</th>
                                            <th>Deliver To</th>
                                            <th>Status</th>
                                            <th class="pe-4 text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT del.*, d.food_name, d.pickup_address, u.name as donor_name, ngo.name as ngo_name, ngo.address as ngo_address 
                                                FROM deliveries del 
                                                JOIN donations d ON del.donation_id = d.id 
                                                JOIN users u ON d.user_id = u.id 
                                                JOIN requests r ON d.id = r.donation_id AND r.status = 'accepted'
                                                JOIN users ngo ON r.ngo_id = ngo.id
                                                WHERE del.volunteer_id = $user_id AND del.status != 'delivered'
                                                ORDER BY del.id DESC";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0):
                                            while($row = $result->fetch_assoc()):
                                        ?>
                                        <tr>
                                            <td class="ps-4">
                                                <span class="fw-bold"><?php echo $row['food_name']; ?></span><br>
                                                <small class="text-muted">Donor: <?php echo $row['donor_name']; ?></small>
                                            </td>
                                            <td><small><?php echo $row['pickup_address']; ?></small></td>
                                            <td>
                                                <span class="fw-bold small"><?php echo $row['ngo_name']; ?></span><br>
                                                <small class="text-muted"><?php echo $row['ngo_address']; ?></small>
                                            </td>
                                            <td><span class="badge bg-info"><?php echo ucfirst($row['status']); ?></span></td>
                                            <td class="pe-4 text-end">
                                                <a href="task-details.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">Manage</a>
                                            </td>
                                        </tr>
                                        <?php 
                                            endwhile; 
                                        else:
                                        ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">No active tasks assigned to you.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
