<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('donor');

$user_id = $_SESSION['user_id'];

// Handle Acceptance/Rejection
if (isset($_GET['action']) && isset($_GET['req_id'])) {
    $req_id = (int)$_GET['req_id'];
    $action = $_GET['action'];
    
    if ($action == 'accept') {
        $conn->query("UPDATE requests SET status = 'accepted' WHERE id = $req_id");
        $req = $conn->query("SELECT donation_id FROM requests WHERE id = $req_id")->fetch_assoc();
        $don_id = $req['donation_id'];
        $conn->query("UPDATE donations SET status = 'accepted' WHERE id = $don_id");
        // Also create delivery entry
        $conn->query("INSERT INTO deliveries (donation_id, status) VALUES ($don_id, 'assigned')");
    } else if ($action == 'reject') {
        $conn->query("UPDATE requests SET status = 'rejected' WHERE id = $req_id");
    }
    redirect('requests.php');
}

include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-4">Donation Requests</h2>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">NGO Name</th>
                                    <th>Food Item</th>
                                    <th>Requested On</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT r.*, u.name as ngo_name, d.food_name 
                                        FROM requests r 
                                        JOIN users u ON r.ngo_id = u.id 
                                        JOIN donations d ON r.donation_id = d.id 
                                        WHERE d.user_id = $user_id AND r.status = 'pending'
                                        ORDER BY r.requested_at DESC";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0):
                                    while($row = $result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold"><?php echo $row['ngo_name']; ?></span>
                                    </td>
                                    <td><?php echo $row['food_name']; ?></td>
                                    <td><?php echo date('M d, Y H:i', strtotime($row['requested_at'])); ?></td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td class="pe-4 text-end">
                                        <a href="requests.php?action=accept&req_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success me-2">Accept</a>
                                        <a href="requests.php?action=reject&req_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger">Reject</a>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile; 
                                else:
                                ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No pending requests at the moment.</td>
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
