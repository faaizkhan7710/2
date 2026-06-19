<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('admin');

// Get global statistics
$total_users = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$total_donations = $conn->query("SELECT COUNT(*) as count FROM donations")->fetch_assoc()['count'];
$total_meals = $conn->query("SELECT meals_saved FROM impact_stats LIMIT 1")->fetch_assoc()['meals_saved'];
$total_ngos = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'ngo'")->fetch_assoc()['count'];

include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-4">Platform Administration</h2>

            <div class="row dashboard-stats mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card p-3 border-0 shadow-sm bg-primary text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-0"><?php echo $total_users; ?></h3>
                                <small>Total Users</small>
                            </div>
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card p-3 border-0 shadow-sm bg-success text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-0"><?php echo $total_donations; ?></h3>
                                <small>Total Donations</small>
                            </div>
                            <i class="fas fa-box-open"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card p-3 border-0 shadow-sm bg-info text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-0"><?php echo $total_meals; ?></h3>
                                <small>Meals Saved</small>
                            </div>
                            <i class="fas fa-utensils"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card p-3 border-0 shadow-sm bg-warning text-dark">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-0"><?php echo $total_ngos; ?></h3>
                                <small>NGO Partners</small>
                            </div>
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white fw-bold py-3">Platform Activity (Recent Donations)</div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">Food Item</th>
                                            <th>Donor</th>
                                            <th>Status</th>
                                            <th class="pe-4">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT d.*, u.name as donor_name FROM donations d JOIN users u ON d.user_id = u.id ORDER BY d.created_at DESC LIMIT 5";
                                        $res = $conn->query($sql);
                                        while($row = $res->fetch_assoc()):
                                        ?>
                                        <tr>
                                            <td class="ps-4 fw-bold"><?php echo $row['food_name']; ?></td>
                                            <td><?php echo $row['donor_name']; ?></td>
                                            <td><span class="badge bg-light text-dark"><?php echo ucfirst($row['status']); ?></span></td>
                                            <td class="pe-4 small text-muted"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white fw-bold py-3">Quick Actions</div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="manage-ngos.php" class="btn btn-outline-success text-start"><i class="fas fa-user-check me-2"></i> Verify New NGOs</a>
                                <a href="reports.php" class="btn btn-outline-primary text-start"><i class="fas fa-file-export me-2"></i> Generate Monthly Report</a>
                                <a href="settings.php" class="btn btn-outline-secondary text-start"><i class="fas fa-tools me-2"></i> Platform Settings</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
