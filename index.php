<?php
// VERSION TEST - Sans vérification de session
// Démarrer la session
session_start();

// AJOUTER CES 2 LIGNES ICI !!!
define('BASE_PATH', __DIR__);
require_once BASE_PATH . '/vendor/autoload.php';

// POUR TEST UNIQUEMENT - Définir des valeurs par défaut
$userName = 'Ahmed Benali'; // Nom de test

// Limiter les pages aux seules qui existent
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$allowedPages = ['dashboard']; // Garder uniquement dashboard pour l'instant

// Vérifier si la page demandée est autorisée
if (!in_array($page, $allowedPages)) {
    $page = 'dashboard'; // Page par défaut si page non autorisée
}

$currentPage = $page;

// Include header
include 'includes/gestionnaire/gestionnaire_header.php';

// Include navbar
include 'includes/gestionnaire/gestionnaire_navbar.php';

// Simplifier le switch pour n'inclure que dashboard
switch ($page) {
    case 'dashboard':
    default:
        include 'gestionnaire/dashboard.php';
        break;
}

// Include footer
include 'includes/gestionnaire/gestionnaire_footer.php';
?>