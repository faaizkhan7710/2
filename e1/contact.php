<?php
require_once 'includes/config.php';
include 'includes/header.php';
?>

<div class="bg-success text-white py-5 mb-5">
    <div class="container text-center">
        <h1 class="fw-bold">Contact Us</h1>
        <p class="lead">Have questions or want to partner with us? Reach out!</p>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 p-4">
                <h3 class="fw-bold mb-4">Send a Message</h3>
                <form>
                    <div class="mb-3">
                        <label class="form-label">Your Name</label>
                        <input type="text" class="form-control" placeholder="Enter your name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-control" placeholder="What is this about?">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" rows="5" placeholder="How can we help?"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-2">Send Message</button>
                </form>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="ps-md-5">
                <h3 class="fw-bold mb-4">Get in Touch</h3>
                <div class="d-flex mb-4">
                    <div class="icon-box text-success me-3"><i class="fas fa-map-marker-alt fa-2x"></i></div>
                    <div>
                        <h5 class="fw-bold">Our Office</h5>
                        <p class="text-muted">Sector F-7/2, Islamabad, Pakistan</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="icon-box text-success me-3"><i class="fas fa-phone-alt fa-2x"></i></div>
                    <div>
                        <h5 class="fw-bold">Phone Number</h5>
                        <p class="text-muted">+92 300 1234567</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="icon-box text-success me-3"><i class="fas fa-envelope fa-2x"></i></div>
                    <div>
                        <h5 class="fw-bold">Email Address</h5>
                        <p class="text-muted">info@foodshare.pk</p>
                    </div>
                </div>
                
                <h4 class="fw-bold mt-5 mb-3">Follow Us</h4>
                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-outline-success rounded-circle"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-success rounded-circle"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-outline-success rounded-circle"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="btn btn-outline-success rounded-circle"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
