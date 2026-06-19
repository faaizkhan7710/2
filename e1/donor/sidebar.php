<div class="sidebar py-4">
    <div class="text-center mb-4">
        <img src="../assets/images/default_profile.png" class="rounded-circle border border-3 border-success p-1 mb-2" width="80" height="80">
        <h6 class="fw-bold mb-0"><?php echo $_SESSION['name']; ?></h6>
        <span class="badge bg-success small">Food Donor</span>
    </div>
    <div class="list-group list-group-flush">
        <a href="dashboard.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a href="add-donation.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'add-donation.php' ? 'active' : ''; ?>">
            <i class="fas fa-plus-circle me-2"></i> Add Donation
        </a>
        <a href="my-donations.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'my-donations.php' ? 'active' : ''; ?>">
            <i class="fas fa-list me-2"></i> My Donations
        </a>
        <a href="requests.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'requests.php' ? 'active' : ''; ?>">
            <i class="fas fa-hands-helping me-2"></i> Requests
        </a>
        <a href="profile.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
            <i class="fas fa-user me-2"></i> My Profile
        </a>
        <a href="../logout.php" class="sidebar-link text-danger">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>
