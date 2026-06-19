<?php
require_once 'includes/config.php';

// Fetch impact statistics
$stats_res = $conn->query("SELECT * FROM impact_stats LIMIT 1");
$stats = $stats_res->fetch_assoc();

// Fetch recent donations
$donations_res = $conn->query("SELECT d.*, u.name as donor_name FROM donations d JOIN users u ON d.user_id = u.id WHERE d.status = 'available' ORDER BY d.created_at DESC LIMIT 3");

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-3 fw-bold mb-3">Save Food, Feed People</h1>
        <p class="lead mb-5 fs-4">Join Pakistan's largest food sharing network. Connect donors with NGOs to reduce waste and fight hunger.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="register.php?role=donor" class="btn btn-warning btn-lg px-5 py-3 rounded-pill fw-bold">Donate Food</a>
            <a href="register.php?role=ngo" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold">Find Food</a>
        </div>
    </div>
</section>

<!-- Impact Counter Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="card p-4 stat-card h-100">
                    <h2 class="fw-bold text-success"><?php echo number_format($stats['meals_saved']); ?>+</h2>
                    <p class="text-muted mb-0">Meals Saved</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card p-4 stat-card h-100">
                    <h2 class="fw-bold text-success"><?php echo number_format($stats['food_saved_kg']); ?> kg</h2>
                    <p class="text-muted mb-0">Food Saved</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card p-4 stat-card h-100">
                    <h2 class="fw-bold text-success"><?php echo number_format($stats['families_helped']); ?>+</h2>
                    <p class="text-muted mb-0">Families Helped</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card p-4 stat-card h-100">
                    <h2 class="fw-bold text-success"><?php echo number_format($stats['co2_reduced']); ?> kg</h2>
                    <p class="text-muted mb-0">CO₂ Reduced</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recent Donations -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Recent Donations</h2>
            <p class="text-muted">Available food items ready for pickup</p>
        </div>
        <div class="row">
            <?php if ($donations_res->num_rows > 0): ?>
                <?php while($row = $donations_res->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 donation-card">
                            <img src="uploads/<?php echo $row['image'] ?: 'food-placeholder.jpg'; ?>" class="card-img-top" alt="Food Image" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-success"><?php echo $row['category']; ?></span>
                                    <span class="text-muted small"><i class="far fa-clock me-1"></i>Exp: <?php echo date('H:i', strtotime($row['expiry_time'])); ?></span>
                                </div>
                                <h5 class="card-title fw-bold"><?php echo $row['food_name']; ?></h5>
                                <p class="card-text text-muted small"><?php echo substr($row['description'], 0, 100); ?>...</p>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="donor-info">
                                        <i class="fas fa-user-circle text-success me-1"></i>
                                        <span class="small"><?php echo $row['donor_name']; ?></span>
                                    </div>
                                    <a href="login.php" class="btn btn-sm btn-outline-success">Request Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No active donations at the moment. Be the first to donate!</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="text-center mt-4">
            <a href="available-food.php" class="btn btn-success px-4 py-2">View All Donations</a>
        </div>
    </div>
</section>

<!-- Success Stories -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">How It Works</h2>
        </div>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="p-4">
                    <div class="icon-box mb-4 text-success"><i class="fas fa-box-open fa-3x"></i></div>
                    <h4>Donors Post Food</h4>
                    <p class="text-muted">Restaurants or individuals list surplus food on the platform.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4">
                    <div class="icon-box mb-4 text-success"><i class="fas fa-search-location fa-3x"></i></div>
                    <h4>NGOs Request</h4>
                    <p class="text-muted">Verified NGOs browse and request available food near them.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4">
                    <div class="icon-box mb-4 text-success"><i class="fas fa-truck-loading fa-3x"></i></div>
                    <h4>Volunteers Deliver</h4>
                    <p class="text-muted">Volunteers pick up the food and deliver it to those in need.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
