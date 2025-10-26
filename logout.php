<?php
session_start();
$redirect = 'landing.php';

// Détruire la session complètement
$_SESSION = [];
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}
session_destroy();

header("Location: $redirect?success=logout");
exit();
?>
