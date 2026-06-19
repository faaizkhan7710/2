<?php
define('ROOT_PATH', '../');
require_once '../includes/config.php';
checkRole('ngo');

$user_id = $_SESSION['user_id'];

// Fetch user data
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    $update_sql = "UPDATE users SET name = '$name', email = '$email', phone = '$phone', address = '$address' WHERE id = $user_id";
    
    if ($conn->query($update_sql)) {
        $_SESSION['name'] = $name;
        $success = "Profile updated successfully!";
        // Refresh user data
        $user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();
    } else {
        $error = "Error updating profile: " . $conn->error;
    }
}

include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-4">NGO Profile</h2>

            <?php if (isset($success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-4">
                            <img src="../assets/images/default_profile.png" class="rounded-circle border border-3 border-success" width="120" height="120">
                            <h5 class="fw-bold mt-3 mb-1"><?php echo $user['name']; ?></h5>
                            <span class="badge bg-primary mb-3">NGO Partner</span>
                            <p class="text-muted small mb-0">Member since <?php echo date('M Y', strtotime($user['created_at'])); ?></p>
                            <div class="mt-3">
                                <span class="badge bg-info text-dark"><i class="fas fa-star me-1"></i> <?php echo $user['points']; ?> Points</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white fw-bold py-3">
                            Profile Information
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Organization Name</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo $user['name']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="<?php echo $user['phone']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <textarea name="address" class="form-control" rows="3"><?php echo $user['address']; ?></textarea>
                                </div>
                                <button type="submit" name="update_profile" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i> Update Profile
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>