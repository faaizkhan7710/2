<div class="sidebar py-4">
    <div class="text-center mb-4">
        <img src="../assets/images/default_profile.png" class="rounded-circle border border-3 border-success p-1 mb-2" width="80" height="80">
        <h6 class="fw-bold mb-0">Administrator</h6>
        <span class="badge bg-danger small">Super Admin</span>
    </div>
    <div class="list-group list-group-flush">
        <a href="dashboard.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a href="manage-users.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage-users.php' ? 'active' : ''; ?>">
            <i class="fas fa-users me-2"></i> Manage Users
        </a>
        <a href="manage-donations.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage-donations.php' ? 'active' : ''; ?>">
            <i class="fas fa-box me-2"></i> Manage Donations
        </a>
        <a href="manage-ngos.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage-ngos.php' ? 'active' : ''; ?>">
            <i class="fas fa-building me-2"></i> Manage NGOs
        </a>
        <a href="reports.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'active' : ''; ?>">
            <i class="fas fa-chart-bar me-2"></i> Impact Reports
        </a>
        <a href="settings.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
            <i class="fas fa-cog me-2"></i> Settings
        </a>
        <a href="../logout.php" class="sidebar-link text-danger">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>
