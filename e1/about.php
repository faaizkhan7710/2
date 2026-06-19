<?php
require_once 'includes/config.php';
include 'includes/header.php';
?>

<div class="bg-success text-white py-5 mb-5">
    <div class="container text-center">
        <h1 class="fw-bold">About FoodShare Pakistan</h1>
        <p class="lead">Fighting hunger and food waste, one meal at a time.</p>
    </div>
</div>

<div class="container my-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h2 class="fw-bold mb-4 border-bottom pb-2">Our Mission</h2>
            <p class="text-muted">In Pakistan, millions of people suffer from food insecurity while tons of edible food is wasted daily in restaurants, marriage halls, and households. FoodShare Pakistan was founded to bridge this gap.</p>
            <p class="text-muted">Our platform connects those with surplus food directly to the organizations that can distribute it to those in need, ensuring that no good meal goes to waste.</p>
        </div>
        <div class="col-md-6 text-center">
            <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="img-fluid rounded shadow" alt="Mission">
        </div>
    </div>

    <div class="row text-center mt-5">
        <div class="col-md-4 mb-4">
            <div class="card p-4 h-100 border-0 shadow-sm">
                <i class="fas fa-utensils fa-3x text-success mb-3"></i>
                <h4 class="fw-bold">Reduce Waste</h4>
                <p class="text-muted">Minimizing the environmental impact of food waste in landfills.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 h-100 border-0 shadow-sm">
                <i class="fas fa-hands-helping fa-3x text-success mb-3"></i>
                <h4 class="fw-bold">Support NGOs</h4>
                <p class="text-muted">Empowering local charities with resources to feed more people.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 h-100 border-0 shadow-sm">
                <i class="fas fa-users fa-3x text-success mb-3"></i>
                <h4 class="fw-bold">Community</h4>
                <p class="text-muted">Building a network of volunteers and donors committed to social good.</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
