<?php
// Include header
include '../includes/gestionnaire/gestionnaire_header.php';

// Include navbar
include '../includes/gestionnaire/gestionnaire_navbar.php';

// Set current page for active state
$currentPage = 'dashboard';
?>

<div class="main-content">
  <div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="dashboard-card">
          <div class="card-header">
            <h1 class="card-title mb-0">
              <i class="bi bi-speedometer2 me-2"></i>
              Tableau de bord - Gestionnaire
            </h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
      <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
          <div class="stat-icon" style="background: linear-gradient(135deg, #28a745, #2ecc71);">
            <i class="bi bi-geo-alt"></i>
          </div>
          <div class="stat-number">12</div>
          <div class="stat-label">Terrains actifs</div>
        </div>
      </div>
      
      <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
          <div class="stat-icon" style="background: linear-gradient(135deg, #007bff, #0056b3);">
            <i class="bi bi-calendar-check"></i>
          </div>
          <div class="stat-number">48</div>
          <div class="stat-label">Réservations aujourd'hui</div>
        </div>
      </div>
      
      <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
          <div class="stat-icon" style="background: linear-gradient(135deg, #ffc107, #ffb300);">
            <i class="bi bi-trophy"></i>
          </div>
          <div class="stat-number">5</div>
          <div class="stat-label">Tournois en cours</div>
        </div>
      </div>
      
      <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
          <div class="stat-icon" style="background: linear-gradient(135deg, #dc3545, #e74c3c);">
            <i class="bi bi-envelope"></i>
          </div>
          <div class="stat-number">23</div>
          <div class="stat-label">Messages non lus</div>
        </div>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
      <div class="col-lg-8 mb-4">
        <div class="dashboard-card">
          <div class="card-header">
            <h5 class="card-title mb-0">
              <i class="bi bi-clock-history me-2"></i>
              Activité récente
            </h5>
          </div>
          <div class="card-body p-0">
            <div class="table-container">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Heure</th>
                    <th>Statut</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><i class="bi bi-calendar-check text-success"></i> Réservation</td>
                    <td>Nouvelle réservation - Terrain A</td>
                    <td>14:30</td>
                    <td><span class="badge badge-success">Confirmée</span></td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-trophy text-warning"></i> Tournoi</td>
                    <td>Tournoi de football démarré</td>
                    <td>13:45</td>
                    <td><span class="badge badge-warning">En cours</span></td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-envelope text-info"></i> Message</td>
                    <td>Nouveau message de l'utilisateur</td>
                    <td>12:15</td>
                    <td><span class="badge badge-danger">Non lu</span></td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-geo-alt text-primary"></i> Terrain</td>
                    <td>Maintenance terminée - Terrain B</td>
                    <td>11:00</td>
                    <td><span class="badge badge-success">Terminé</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-4 mb-4">
        <div class="dashboard-card">
          <div class="card-header">
            <h5 class="card-title mb-0">
              <i class="bi bi-graph-up me-2"></i>
              Statistiques rapides
            </h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted">Réservations cette semaine</span>
                <span class="fw-bold text-success">+15%</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-success" style="width: 75%"></div>
              </div>
            </div>
            
            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted">Taux d'occupation</span>
                <span class="fw-bold text-primary">85%</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-primary" style="width: 85%"></div>
              </div>
            </div>
            
            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted">Satisfaction client</span>
                <span class="fw-bold text-warning">4.8/5</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-warning" style="width: 96%"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
// Include footer
include '../includes/gestionnaire/gestionnaire_footer.php';
?>
