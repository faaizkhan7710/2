<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('volunteer');

$user_id = $_SESSION['user_id'];

$sql = "SELECT del.*, d.food_name, d.pickup_address, u.name as donor_name, ngo.name as ngo_name, ngo.address as ngo_address 
        FROM deliveries del 
        JOIN donations d ON del.donation_id = d.id 
        JOIN users u ON d.user_id = u.id 
        JOIN requests r ON d.id = r.donation_id AND r.status = 'accepted'
        JOIN users ngo ON r.ngo_id = ngo.id
        WHERE del.volunteer_id = $user_id AND del.status = 'delivered'
        ORDER BY del.id DESC";
$result = $conn->query($sql);

include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-4">Completed Tasks</h2>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">
                    All Completed Deliveries
                </div>
                <div class="card-body p-0">
                    <?php if ($result->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Food Item</th>
                                        <th>Pickup From</th>
                                        <th>Deliver To</th>
                                        <th>Delivery Date</th>
                                        <th class="pe-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $result->fetch_assoc()): ?>
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
                                        <td><?php echo $row['delivery_time'] ? date('M d, Y H:i', strtotime($row['delivery_time'])) : '-'; ?></td>
                                        <td class="pe-4"><span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Delivered</span></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-tasks fa-4x mb-3"></i>
                            <h5>No completed tasks yet</h5>
                            <p>You haven't completed any delivery tasks yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>