<?php
session_start();

require_once 'classes/auth.php';
require_once 'includes/authmiddleware.php';
$auth = new Auth();
$error = '';

// Rediriger si déjà connecté
if (AuthMiddleware::isLoggedIn()) {
    $user = AuthMiddleware::getCurrentUser();
    $userType = $user['user_type'] ?? 'client';
    if ($userType === 'admin') {
        header('Location: admin/dashboard.php');
    } elseif ($userType === 'gestionnaire') {
        header('Location: gestionnaire/dashboard.php');
    } else {
        header('Location: user/dashboard.php');
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
    $secretKey = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe";

    // Vérification reCAPTCHA
    if (!empty($recaptchaResponse)) {
        $response = @file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse");
        if ($response !== false) {
            $responseData = json_decode($response);
            if (!$responseData->success) {
                $error = "Captcha invalide! Veuillez réessayer.";
            }
        }
    } else {
        $error = "Veuillez cocher le captcha.";
    }

    if (empty($error)) {
        if (empty($email) || empty($password)) {
            $error = "Veuillez remplir tous les champs.";
        } else {
            if ($auth->login($email, $password)) {
                $user = AuthMiddleware::getCurrentUser();
                $userType = $user['user_type'] ?? 'client';

                // Redirection selon rôle
                if ($userType === 'admin') {
                    header('Location: admin/dashboard.php?success=login');
                } elseif ($userType === 'gestionnaire') {
                    header('Location: gestionnaire/dashboard.php?success=login');
                } else {
                    header('Location: user/dashboard.php?success=login');
                }
                exit;
            } else {
                $error = "Email ou mot de passe incorrect.";
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
    <title>Connexion - Book & Play</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
            padding: 1rem;
            position: relative;
            overflow-y: auto;
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
            max-width: 600px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 1;
            border: 1px solid rgba(200, 255, 0, 0.2);
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-container img {
            width: 400px;
            height: auto;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.1));
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

        .form-group {
            margin-bottom: 1.5rem;
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

        .recaptcha-wrapper {
            margin: 1.5rem 0;
            display: flex;
            justify-content: center;
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

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
            font-size: 0.95rem;
        }

        .register-link a {
            color: #1a4d4d;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: #c8ff00;
        }

        .error-message {
            background: linear-gradient(135deg, #ffe0e0 0%, #ffd0d0 100%);
            border: 2px solid #ffb0b0;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: #c00;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error-message i {
            font-size: 1.2rem;
        }

        .forgot-password {
            text-align: right;
            margin-top: 0.5rem;
        }

        .forgot-password a {
            color: #1a4d4d;
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.3s;
        }

        .forgot-password a:hover {
            color: #c8ff00;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 2rem 1.5rem;
            }

            .form-title {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="logo-container">
            <img src="assets/logo.png" alt="Book&Play Logo">
        </div>
        
        <h1 class="form-title">
            <i class="bi bi-box-arrow-in-right"></i>
            Connexion
        </h1>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="votre@email.com">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <div class="input-wrapper">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                </div>
                <div class="forgot-password">
                    <a href="forgot-password.php">
                        <i class="bi bi-question-circle"></i> Mot de passe oublié ?
                    </a>
                </div>
            </div>

            <div class="recaptcha-wrapper">
                <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
            </div>

            <?php AuthMiddleware::csrfField(); ?>
            
            <button type="submit" class="submit-btn">
                <i class="bi bi-check-circle"></i>
                Se connecter
            </button>

            <div class="register-link">
                <i class="bi bi-person-plus"></i>
                Pas encore de compte ? <a href="register.php">S'inscrire</a>
            </div>
        </form>
    </div>
</body>
</html>