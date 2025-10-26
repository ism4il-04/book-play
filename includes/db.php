<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

class Database {
    private static ?PDO $connection = null;

    /**
     * Initialise ou retourne la connexion à la base de données
     */
    public static function getConnection(): PDO {
        if (self::$connection === null) {
            // Charger les variables d'environnement (.env)
            $dotenv = Dotenv::createImmutable(__DIR__ . "/..");
            $dotenv->load();

            try {
                self::$connection = new PDO(
                    'mysql:host=' . $_ENV['DB_HOST'] .
                    ';port=' . $_ENV['DB_PORT'] .
                    ';dbname=' . $_ENV['DB_NAME'] .
                    ';charset=utf8',
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASSWORD']
                );

                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }
        }

        return self::$connection;
    }

    /**
     * Exécute une requête préparée (INSERT, UPDATE, DELETE)
     */
    public static function execute(string $sql, array $params = []): bool {
        $stmt = self::getConnection()->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Récupère une seule ligne
     */
    public static function fetchOne(string $sql, array $params = []): ?array {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() ?: null;
    }

    /**
     * Récupère plusieurs lignes
     */
    public static function fetchAll(string $sql, array $params = []): array {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
