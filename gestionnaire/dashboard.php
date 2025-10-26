<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(dirname(__FILE__)));
}

// Inclure le fichier de configuration de la base de données
require_once BASE_PATH . '/includes/db.php';

class DashboardService {
    private $db;
    
    public function __construct() {
        try {
            // Utiliser la classe Database existante
            $database = Database::getInstance();
            $this->db = $database->getConnection();
        } catch (Exception $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }
    
    public function getStats() {
        return [
            'terrains_crees' => $this->getTerrainsCount(),
            'terrains_crees_variation' => '+1 cette semaine',
            'en_attente' => $this->getPendingCount(),
            'en_attente_text' => 'À traiter rapidement',
            'cette_semaine' => $this->getWeekCount(),
            'cette_semaine_variation' => '+8 vs semaine passée',
            'tournois_en_cours' => $this->getTournoisCount(),
            'equipes_inscrites' => $this->getEquipesCount()
        ];
    }
    
    private function getTerrainsCount() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM terrain");
        return $stmt->fetchColumn() ?: 0;
    }
    
    private function getPendingCount() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM reservation WHERE status = 'en attente'");
        return $stmt->fetchColumn() ?: 0;
    }
    
    private function getWeekCount() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM reservation WHERE WEEK(date_reservation) = WEEK(NOW())");
        return $stmt->fetchColumn() ?: 0;
    }
    
    private function getTournoisCount() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM tournoi WHERE status = 'accepté'");
        return $stmt->fetchColumn() ?: 0;
    }
    
    private function getEquipesCount() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM equipe");
        return $stmt->fetchColumn() ?: 0;
    }
    
    public function getActivites() {
        $query = "SELECT 
                    CONCAT(u.prenom, ' ', u.nom) as nom_complet,
                    r.status,
                    r.date_reservation,
                    t.type_terrain
                  FROM reservation r
                  INNER JOIN client c ON r.id_client = c.id
                  INNER JOIN utilisateur u ON c.id = u.id
                  INNER JOIN terrain t ON r.id_terrain = t.id_terrain
                  ORDER BY r.date_reservation DESC, r.heure_depart DESC
                  LIMIT 5";
        
        try {
            $stmt = $this->db->query($query);
            $activites = [];
            
            while ($row = $stmt->fetch()) {
                $activites[] = [
                    'initiales' => $this->getInitials($row['nom_complet']),
                    'nom' => $row['nom_complet'],
                    'action' => $this->getAction($row['status']),
                    'temps' => $this->getTimeAgo($row['date_reservation']),
                    'terrain' => 'Terrain: ' . $row['type_terrain'],
                    'type' => $row['status']
                ];
            }
            
            // Si aucune donnée, retourner des exemples
            if (empty($activites)) {
                $activites = $this->getDemoActivites();
            }
            
            return $activites;
        } catch (Exception $e) {
            return $this->getDemoActivites();
        }
    }
    
    private function getDemoActivites() {
        return [
            [
                'initiales' => 'KA',
                'nom' => 'Karim Alami',
                'action' => 'a fait une réservation',
                'temps' => 'Il y a 7 heures',
                'terrain' => 'Terrain: Gazon synthétique',
                'type' => 'en attente'
            ],
            [
                'initiales' => 'SB',
                'nom' => 'Sofia Bennani',
                'action' => 'réservation acceptée',
                'temps' => 'Il y a 1 jour',
                'terrain' => 'Terrain: Gazon naturel',
                'type' => 'accepté'
            ]
        ];
    }
    
    private function getInitials($name) {
        $parts = explode(' ', $name);
        $initials = '';
        foreach ($parts as $part) {
            if (!empty($part)) {
                $initials .= strtoupper(substr($part, 0, 1));
            }
        }
        return substr($initials, 0, 2);
    }
    
    private function getAction($status) {
        $actions = [
            'en attente' => 'a fait une réservation',
            'accepté' => 'réservation acceptée',
            'refusé' => 'réservation refusée'
        ];
        return $actions[$status] ?? 'action';
    }
    
    private function getTimeAgo($datetime) {
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        
        if ($diff->d > 0) {
            return 'Il y a ' . $diff->d . ' jour' . ($diff->d > 1 ? 's' : '');
        } elseif ($diff->h > 0) {
            return 'Il y a ' . $diff->h . ' heure' . ($diff->h > 1 ? 's' : '');
        } else {
            return 'Il y a ' . $diff->i . ' minute' . ($diff->i > 1 ? 's' : '');
        }
    }
}

// Utilisation
try {
    $service = new DashboardService();
    $stats = $service->getStats();
    $activites = $service->getActivites();
} catch (Exception $e) {
    die("Une erreur est survenue: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="main-content">
    <div class="container-fluid">
        <!-- En-tête avec logo -->
        <div class="page-header mb-4">
            <div class="header-wrapper">
               
                <div class="header-text">
                    <h2 class="page-title">Tableau de bord</h2>
                    <p class="page-subtitle">Vue d'ensemble de votre activité</p>
                </div>
            </div>
        </div>

        <!-- Cartes statistiques -->
        <div class="row g-4 mb-4">
            <!-- Terrains créés -->
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-label">Terrains créés</span>
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-th"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $stats['terrains_crees']; ?></div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span><?php echo $stats['terrains_crees_variation']; ?></span>
                    </div>
                </div>
            </div>

            <!-- En attente -->
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-label">En attente</span>
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $stats['en_attente']; ?></div>
                    <div class="stat-trend neutral">
                        <span><?php echo $stats['en_attente_text']; ?></span>
                    </div>
                </div>
            </div>

            <!-- Cette semaine -->
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-label">Cette semaine</span>
                        <div class="stat-icon bg-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $stats['cette_semaine']; ?></div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span><?php echo $stats['cette_semaine_variation']; ?></span>
                    </div>
                </div>
            </div>

            <!-- Tournois en cours -->
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-label">Tournois en cours</span>
                        <div class="stat-icon bg-info">
                            <i class="fas fa-trophy"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $stats['tournois_en_cours']; ?></div>
                    <div class="stat-trend neutral">
                        <span><?php echo $stats['equipes_inscrites']; ?> équipes inscrites</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activités récentes -->
        <div class="row">
            <div class="col-12">
                <div class="activity-card">
                    <h5 class="activity-title">Activités récentes</h5>
                    
                    <div class="activity-list">
                        <?php foreach ($activites as $activite): ?>
                        <div class="activity-item">
                            <div class="activity-avatar" style="background-color: #0c5e63;">
                                <?php echo $activite['initiales']; ?>
                            </div>
                            <div class="activity-content">
                                <div class="activity-header">
                                    <strong><?php echo $activite['nom']; ?></strong>
                                    <span class="activity-action"><?php echo $activite['action']; ?></span>
                                </div>
                                <div class="activity-meta">
                                    <span><?php echo $activite['temps']; ?></span>
                                    <?php if ($activite['terrain']): ?>
                                    <span class="mx-2">•</span>
                                    <span><?php echo $activite['terrain']; ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="activity-status">
                                <?php if ($activite['type'] === 'en attente'): ?>
                                    <i class="fas fa-clock text-warning"></i>
                                <?php elseif ($activite['type'] === 'accepté'): ?>
                                    <i class="fas fa-check-circle text-success"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header { margin-bottom: 2rem; }
.page-title { font-size: 1.75rem; font-weight: 700; color: #2c3e50; margin-bottom: 0.5rem; }
.page-subtitle { color: #6c757d; margin: 0; }
.stat-card { background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; }
.stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12); }
.stat-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
.stat-label { font-size: 0.875rem; color: #6c757d; font-weight: 500; }
.stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; }
.stat-icon.bg-primary { background: linear-gradient(135deg, #007bff, #0056b3); }
.stat-icon.bg-warning { background: linear-gradient(135deg, #ffc107, #ffb300); }
.stat-icon.bg-success { background: linear-gradient(135deg, #28a745, #2ecc71); }
.stat-icon.bg-info { background: linear-gradient(135deg, #17a2b8, #20c997); }
.stat-value { font-size: 2.5rem; font-weight: 700; color: #2c3e50; margin-bottom: 0.5rem; }
.stat-trend { font-size: 0.875rem; display: flex; align-items: center; gap: 0.25rem; }
.stat-trend.positive { color: #28a745; }
.stat-trend.neutral { color: #6c757d; }
.activity-card { background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); }
.activity-title { font-size: 1.25rem; font-weight: 600; color: #2c3e50; margin-bottom: 1.5rem; }
.activity-list { display: flex; flex-direction: column; gap: 1rem; }
.activity-item { display: flex; align-items: center; gap: 1rem; padding: 1rem; border-radius: 12px; transition: background 0.3s ease; }
.activity-item:hover { background: rgba(40, 167, 69, 0.05); }
.activity-avatar { width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1rem; }
.activity-content { flex: 1; }
.activity-header { margin-bottom: 0.25rem; }
.activity-action { color: #6c757d; margin-left: 0.5rem; }
.activity-meta { font-size: 0.875rem; color: #6c757d; }
.activity-status { font-size: 1.25rem; }
.header-wrapper {
    display: flex;
    align-items: center;
    gap: 2rem;
    padding: 1rem 0;
    background-color: #fff;
}

.logo-container {
    flex-shrink: 0;
    width: 150px;
    height: auto;
    display: flex;
    align-items: center;
}

.dashboard-logo {
    max-width: 100%;
    height: auto;
    display: block;
}

.header-text {
    flex-grow: 1;
}
</style>

</body>
</html>