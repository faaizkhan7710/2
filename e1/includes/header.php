<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - <?php echo APP_TAGLINE; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo defined('ROOT_PATH') ? ROOT_PATH : ''; ?>assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo defined('ROOT_PATH') ? ROOT_PATH : ''; ?>index.php">
                <i class="fas fa-hand-holding-heart me-2"></i>FoodShare Pakistan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="<?php echo defined('ROOT_PATH') ? ROOT_PATH : ''; ?>index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo defined('ROOT_PATH') ? ROOT_PATH : ''; ?>about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo defined('ROOT_PATH') ? ROOT_PATH : ''; ?>contact.php">Contact</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light ms-lg-3 px-4 rounded-pill" href="<?php echo defined('ROOT_PATH') ? ROOT_PATH : ''; ?><?php echo $_SESSION['role']; ?>/dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo defined('ROOT_PATH') ? ROOT_PATH : ''; ?>logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo defined('ROOT_PATH') ? ROOT_PATH : ''; ?>login.php">Login</a></li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-warning text-dark fw-bold ms-lg-3 px-4 rounded-pill" href="<?php echo defined('ROOT_PATH') ? ROOT_PATH : ''; ?>register.php">Join Us</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
