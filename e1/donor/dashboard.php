<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('donor');

$user_id = $_SESSION['user_id'];

// Get statistics
$total_donations = $conn->query("SELECT COUNT(*) as count FROM donations WHERE user_id = $user_id")->fetch_assoc()['count'];
$active_donations = $conn->query("SELECT COUNT(*) as count FROM donations WHERE user_id = $user_id AND status = 'available'")->fetch_assoc()['count'];
$completed_donations = $conn->query("SELECT COUNT(*) as count FROM donations WHERE user_id = $user_id AND status = 'delivered'")->fetch_assoc()['count'];
$pending_requests = $conn->query("SELECT COUNT(r.id) as count FROM requests r JOIN donations d ON r.donation_id = d.id WHERE d.user_id = $user_id AND r.status = 'pending'")->fetch_assoc()['count'];

include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Donor Dashboard</h2>
                <a href="add-donation.php" class="btn btn-success"><i class="fas fa-plus me-2"></i>New Donation</a>
            </div>

            <div class="row dashboard-stats mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card p-3 border-0 shadow-sm bg-primary text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-0"><?php echo $total_donations; ?></h3>
                                <small>Total Donations</small>
                            </div>
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card p-3 border-0 shadow-sm bg-success text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-0"><?php echo $active_donations; ?></h3>
                                <small>Active Now</small>
                            </div>
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card p-3 border-0 shadow-sm bg-info text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-0"><?php echo $completed_donations; ?></h3>
                                <small>Completed</small>
                            </div>
                            <i class="fas fa-truck-loading"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card p-3 border-0 shadow-sm bg-warning text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-0"><?php echo $pending_requests; ?></h3>
                                <small>New Requests</small>
                            </div>
                            <i class="fas fa-bell"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white fw-bold py-3">Recent Donations</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Food Item</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $recent = $conn->query("SELECT * FROM donations WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5");
                                        while($row = $recent->fetch_assoc()):
                                        ?>
                                        <tr>
                                            <td><?php echo $row['food_name']; ?></td>
                                            <td><span class="badge bg-light text-dark"><?php echo $row['category']; ?></span></td>
                                            <td>
                                                <?php
                                                $status_class = [
                                                    'available' => 'bg-success',
                                                    'requested' => 'bg-warning',
                                                    'accepted' => 'bg-info',
                                                    'picked_up' => 'bg-primary',
                                                    'delivered' => 'bg-secondary'
                                                ];
                                                ?>
                                                <span class="badge <?php echo $status_class[$row['status']]; ?>"><?php echo ucfirst($row['status']); ?></span>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                            <td><a href="view-donation.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success">View</a></td>
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
                        <div class="card-header bg-white fw-bold py-3">Donor Reward Points</div>
                        <div class="card-body text-center py-4">
                            <?php
                            $user_points = $conn->query("SELECT points FROM users WHERE id = $user_id")->fetch_assoc()['points'];
                            $badge = "Bronze";
                            $badge_color = "text-secondary";
                            if ($user_points > 500) { $badge = "Platinum"; $badge_color = "text-info"; }
                            else if ($user_points > 300) { $badge = "Gold"; $badge_color = "text-warning"; }
                            else if ($user_points > 100) { $badge = "Silver"; $badge_color = "text-muted"; }
                            ?>
                            <div class="mb-3"><i class="fas fa-medal fa-4x <?php echo $badge_color; ?>"></i></div>
                            <h4 class="fw-bold mb-1"><?php echo $badge; ?> Donor</h4>
                            <p class="text-muted small">You have earned <?php echo $user_points; ?> points</p>
                            <div class="progress mt-3" style="height: 10px;">
                                <div class="progress-bar bg-success" style="width: <?php echo ($user_points % 100); ?>%"></div>
                            </div>
                            <small class="text-muted mt-2 d-block"><?php echo 100 - ($user_points % 100); ?> points more for next level</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
