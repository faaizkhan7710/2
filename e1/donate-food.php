<?php
require_once 'includes/config.php';
if (isLoggedIn() && getRole() == 'donor') {
    redirect('donor/add-donation.php');
} else if (!isLoggedIn()) {
    redirect('login.php?msg=please_login_to_donate');
} else {
    redirect('index.php');
}
?>
