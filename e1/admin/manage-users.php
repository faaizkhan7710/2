<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('admin');

// Handle user actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];
    if ($action == 'delete') {
        $conn->query("DELETE FROM users WHERE id = $id");
    } else if ($action == 'verify') {
        $conn->query("UPDATE users SET is_verified = 1 WHERE id = $id");
    }
    redirect('manage-users.php');
}

include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-4">Manage Platform Users</h2>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM users WHERE role != 'admin' ORDER BY created_at DESC";
                                $res = $conn->query($sql);
                                while($row = $res->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="ps-4 fw-bold"><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><span class="badge bg-light text-dark text-uppercase"><?php echo $row['role']; ?></span></td>
                                    <td>
                                        <?php if($row['is_verified']): ?>
                                            <span class="badge bg-success">Verified</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Unverified</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <?php if(!$row['is_verified']): ?>
                                            <a href="manage-users.php?action=verify&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success me-1">Verify</a>
                                        <?php endif; ?>
                                        <a href="manage-users.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
