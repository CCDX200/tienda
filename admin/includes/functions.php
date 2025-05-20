<?php
function isLoggedIn() {
    session_start();
    return isset($_SESSION['admin_id']);
}
?>