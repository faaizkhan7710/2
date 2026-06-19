<div class="sidebar py-4">
    <div class="text-center mb-4">
        <img src="../assets/images/default_profile.png" class="rounded-circle border border-3 border-success p-1 mb-2" width="80" height="80">
        <h6 class="fw-bold mb-0"><?php echo $_SESSION['name']; ?></h6>
        <span class="badge bg-warning text-dark small">Volunteer</span>
    </div>
    <div class="list-group list-group-flush">
        <a href="dashboard.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a href="pickup-tasks.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'pickup-tasks.php' ? 'active' : ''; ?>">
            <i class="fas fa-truck me-2"></i> Pickup Tasks
        </a>
        <a href="completed-tasks.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'completed-tasks.php' ? 'active' : ''; ?>">
            <i class="fas fa-check-circle me-2"></i> Completed Tasks
        </a>
        <a href="profile.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
            <i class="fas fa-user me-2"></i> My Profile
        </a>
        <a href="../logout.php" class="sidebar-link text-danger">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>
