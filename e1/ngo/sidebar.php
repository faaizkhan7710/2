<div class="sidebar py-4">
    <div class="text-center mb-4">
        <img src="../assets/images/default_profile.png" class="rounded-circle border border-3 border-success p-1 mb-2" width="80" height="80">
        <h6 class="fw-bold mb-0"><?php echo $_SESSION['name']; ?></h6>
        <span class="badge bg-primary small">NGO Partner</span>
    </div>
    <div class="list-group list-group-flush">
        <a href="dashboard.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a href="available-food.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'available-food.php' ? 'active' : ''; ?>">
            <i class="fas fa-search me-2"></i> Available Food
        </a>
        <a href="my-requests.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'my-requests.php' ? 'active' : ''; ?>">
            <i class="fas fa-paper-plane me-2"></i> My Requests
        </a>
        <a href="received-food.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'received-food.php' ? 'active' : ''; ?>">
            <i class="fas fa-check-double me-2"></i> Received Food
        </a>
        <a href="profile.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
            <i class="fas fa-user me-2"></i> NGO Profile
        </a>
        <a href="../logout.php" class="sidebar-link text-danger">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>
