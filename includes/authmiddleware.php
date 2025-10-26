<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}   

class AuthMiddleware {
    public static function requireAuth() {
        if (!isset($_SESSION['id'])) {
            header('Location: ../login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
            exit;
        }
    }

    public static function getCurrentUser(): array {
        return [
            'id' => $_SESSION['id'] ?? null,
            'prenom' => $_SESSION['prenom'] ?? null,
            'nom' => $_SESSION['nom'] ?? null,
            'email' => $_SESSION['email'] ?? null,
            'num_tel' => $_SESSION['num_tel'] ?? null,
        ];
    }

    public static function isLoggedIn(): bool {
        return isset($_SESSION['id']);
    }

    public static function generateCsrfToken(): string {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrfToken(string $token): bool {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function csrfField(): void {
        echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(self::generateCsrfToken()) . '">';
    }
}
?>