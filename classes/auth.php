<?php
require_once __DIR__ . '/../includes/db.php';

class Auth {
    /**
     * Enregistre un nouvel utilisateur
     */
    public function register(string $nom, string $prenom, string $email, string $password, string $num_tel = ''): bool {
        // Vérifier si l'email existe déjà
        $existing = Database::fetchOne("SELECT id FROM utilisateur WHERE email = ?", [$email]);
        if ($existing) {
            return false; // email déjà pris
        }

        // Hacher le mot de passe
        $hashed = password_hash($password, PASSWORD_BCRYPT);

        // Insérer le nouvel utilisateur avec le numéro de téléphone
        return Database::execute(
            "INSERT INTO utilisateur (nom, prenom, email, password, num_tel) VALUES (?, ?, ?, ?, ?)",
            [$nom, $prenom, $email, $hashed, $num_tel]
        );
    }

    /**
     * Connecte un utilisateur existant
     */
    public function login(string $email, string $password): bool {
        $user = Database::fetchOne("SELECT * FROM utilisateur WHERE email = ?", [$email]);

        if ($user && password_verify($password, $user['password'])) {
            // Créer la session
            $_SESSION['id'] = $user['id'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['num_tel'] = $user['num_tel'] ?? '';
            return true;
        }

        return false; // mauvais email ou mot de passe
    }

    /**
     * Déconnecte l'utilisateur (ferme la session)
     */
    public function logout(): void {
        session_unset();
        session_destroy();
    }

    /**
     * Vérifie si un utilisateur est connecté
     */
    public function isLoggedIn(): bool {
        return isset($_SESSION['id']);
    }

    /**
     * Récupère les infos de l'utilisateur connecté
     */
    public function getUser(): ?array {
        if (!$this->isLoggedIn()) return null;
        return [
            'id' => $_SESSION['id'],
            'nom' => $_SESSION['nom'],
            'prenom' => $_SESSION['prenom'],
            'email' => $_SESSION['email'],
            'num_tel' => $_SESSION['num_tel'] ?? ''
        ];
    }
}
?>
