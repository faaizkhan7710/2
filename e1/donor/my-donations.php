<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('donor');

$user_id = $_SESSION['user_id'];

include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-4">My Donations</h2>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Food Item</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Freshness</th>
                                    <th>Status</th>
                                    <th>Posted On</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM donations WHERE user_id = $user_id ORDER BY created_at DESC";
                                $result = $conn->query($sql);
                                while($row = $result->fetch_assoc()):
                                    $status_class = [
                                        'available' => 'bg-success',
                                        'requested' => 'bg-warning',
                                        'accepted' => 'bg-info',
                                        'picked_up' => 'bg-primary',
                                        'delivered' => 'bg-secondary'
                                    ];
                                ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <img src="../uploads/<?php echo $row['image'] ?: 'food-placeholder.jpg'; ?>" class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                            <span class="fw-bold"><?php echo $row['food_name']; ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td>
                                        <div class="progress" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-success" style="width: <?php echo $row['freshness_score']; ?>%"></div>
                                        </div>
                                        <small class="text-muted"><?php echo $row['freshness_score']; ?>% Fresh</small>
                                    </td>
                                    <td><span class="badge <?php echo $status_class[$row['status']]; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                    <td class="pe-4 text-end">
                                        <a href="edit-donation.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                        <a href="view-donation.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
