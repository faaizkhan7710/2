<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('ngo');

$user_id = $_SESSION['user_id'];

include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-4">My Food Requests</h2>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Food Item</th>
                                    <th>Donor</th>
                                    <th>Requested On</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT r.*, d.food_name, u.name as donor_name 
                                        FROM requests r 
                                        JOIN donations d ON r.donation_id = d.id 
                                        JOIN users u ON d.user_id = u.id 
                                        WHERE r.ngo_id = $user_id 
                                        ORDER BY r.requested_at DESC";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0):
                                    while($row = $result->fetch_assoc()):
                                        $status_class = [
                                            'pending' => 'bg-warning',
                                            'accepted' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            'completed' => 'bg-primary'
                                        ];
                                ?>
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold"><?php echo $row['food_name']; ?></span>
                                    </td>
                                    <td><?php echo $row['donor_name']; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['requested_at'])); ?></td>
                                    <td><span class="badge <?php echo $status_class[$row['status']]; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                                    <td class="pe-4 text-end">
                                        <?php if($row['status'] == 'accepted'): ?>
                                            <a href="track-delivery.php?id=<?php echo $row['donation_id']; ?>" class="btn btn-sm btn-outline-info">Track Delivery</a>
                                        <?php endif; ?>
                                        <a href="view-request.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success">View</a>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile; 
                                else:
                                ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">You haven't made any requests yet.</td>
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

<?php include '../includes/footer.php'; ?>
