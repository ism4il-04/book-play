<?php
session_start();
require_once 'classes/auth.php';
require_once 'includes/authmiddleware.php';

$auth = new Auth();
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!AuthMiddleware::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = "Formulaire invalide.";
    } else {
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $num_tel = trim($_POST['num_tel'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (!$nom || !$prenom || !$email || !$password) {
            $errors[] = "Tous les champs sont obligatoires.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalide.";
        } elseif ($password !== $confirm) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        } else {
            if ($auth->register($nom, $prenom, $email, $password, $num_tel)) {
                $success = true;
            } else {
                $errors[] = "Cet email est déjà utilisé.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Book & Play</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #0a2e2e 0%, #1a4d4d 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1920') center/cover no-repeat;
            opacity: 0.15;
            z-index: 0;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2.5rem 3rem;
            width: 100%;
            max-width: 550px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 1;
            border: 1px solid rgba(200, 255, 0, 0.2);
        }

        .form-title {
            text-align: center;
            color: #1a4d4d;
            margin-bottom: 2rem;
            font-size: 2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .form-title i {
            color: #c8ff00;
            font-size: 2.2rem;
        }

        .form-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.2rem;
        }

        .form-group {
            flex: 1;
            position: relative;
        }

        .form-group.full-width {
            width: 100%;
            margin-bottom: 1.2rem;
        }

        label {
            display: block;
            color: #2d5f5f;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: #1a4d4d;
            font-size: 1.1rem;
            z-index: 1;
        }

        input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 2.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s;
            background-color: white;
        }

        input:focus {
            outline: none;
            border-color: #c8ff00;
            box-shadow: 0 0 0 3px rgba(200, 255, 0, 0.1);
        }

        input::placeholder {
            color: #aaa;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #c8ff00 0%, #a8df00 100%);
            color: #1a4d4d;
            border: none;
            padding: 1rem;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
            box-shadow: 0 4px 15px rgba(200, 255, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(200, 255, 0, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #1a4d4d;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s;
        }

        .login-link a:hover {
            color: #c8ff00;
        }

        .error-list {
            background: linear-gradient(135deg, #ffe0e0 0%, #ffd0d0 100%);
            border: 2px solid #ffb0b0;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .error-list ul {
            list-style: none;
        }

        .error-list li {
            color: #c00;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error-list li::before {
            content: '\F33A';
            font-family: 'bootstrap-icons';
            font-weight: bold;
        }

        .success-message {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 2px solid #28a745;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            color: #155724;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .success-message i {
            font-size: 3rem;
            color: #28a745;
        }

        .success-message a {
            color: #1a4d4d;
            font-weight: 700;
            text-decoration: none;
            padding: 0.5rem 1.5rem;
            background-color: #c8ff00;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .success-message a:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 2rem 1.5rem;
            }

            .form-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1 class="form-title">
            <i class="bi bi-person-plus-fill"></i>
            Inscription
        </h1>

        <?php if ($success): ?>
            <div class="success-message">
                <i class="bi bi-check-circle-fill"></i>
                <p>Inscription réussie !</p>
                <a href="login.php">
                    <i class="bi bi-box-arrow-in-right"></i> Se connecter
                </a>
            </div>
        <?php else: ?>
            <?php if ($errors): ?>
                <div class="error-list">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person input-icon"></i>
                            <input type="text" id="nom" name="nom" required value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-badge input-icon"></i>
                            <input type="text" id="prenom" name="prenom" required value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="num_tel">Téléphone</label>
                    <div class="input-wrapper">
                        <i class="bi bi-telephone input-icon"></i>
                        <input type="tel" id="num_tel" name="num_tel" placeholder="+212 6 XX XX XX XX" value="<?= htmlspecialchars($_POST['num_tel'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmer</label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                        </div>
                    </div>
                </div>

                <?php AuthMiddleware::csrfField(); ?>
                
                <button type="submit" class="submit-btn">
                    <i class="bi bi-check-circle"></i>
                    S'inscrire
                </button>

                <div class="login-link">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Déjà un compte ? <a href="login.php">Se connecter</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>