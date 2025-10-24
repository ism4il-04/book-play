<!-- Top Section: Brand & Profile -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm">
  <div class="container d-flex justify-content-between align-items-center">
    <?php
      // graceful fallback for username
      $userName = isset($userName) ? $userName : (isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User');
    ?>

    <!-- Brand Logo - Left Side -->
    <a class="navbar-brand fw-bold text-success d-flex align-items-center gap-2" href="index.php">
      <div class="brand-icon">
        <i class="bi bi-circle-fill"></i>
      </div>
      <span class="brand-text">Book<span class="text-dark">&</span>Play</span>
    </a>

    <!-- Profile Section - Right Side -->
    <div class="d-flex align-items-center gap-3">
      <!-- Notifications -->
      <div class="dropdown">
        <a class="nav-link position-relative" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
          <i class="bi bi-bell fs-5"></i>
          <span class="notif-badge">3</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="notifDropdown">
          <li class="dropdown-header">Notifications</li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item small" href="#">New booking confirmed <span class="text-muted d-block small">2h ago</span></a></li>
          <li><a class="dropdown-item small" href="#">Tournament results posted <span class="text-muted d-block small">1d ago</span></a></li>
          <li><a class="dropdown-item small" href="#">Message from admin <span class="text-muted d-block small">3d ago</span></a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-center" href="#">View all</a></li>
        </ul>
      </div>

      <!-- User Profile -->
      <div class="dropdown">
        <a class="nav-link d-flex align-items-center gap-2 profile-link" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="avatar bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center">
            <?php echo strtoupper(substr($userName,0,1)); ?>
          </div>
          <span class="d-none d-md-inline profile-name"><?php echo htmlspecialchars($userName); ?></span>
          <i class="bi bi-chevron-down ms-1 d-none d-md-inline"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item" href="index.php?page=profile"><i class="bi bi-person me-2"></i>Profile</a></li>
          <li><a class="dropdown-item" href="index.php?page=settings"><i class="bi bi-gear me-2"></i>Settings</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<div class="sub-navbar">
  <div class="container d-flex justify-content-center">
    <ul class="nav nav-pills flex-nowrap overflow-auto">
      <li class="nav-item">
        <a class="nav-link d-flex align-items-center gap-2 <?php echo ($currentPage === 'dashboard') ? 'active' : ''; ?>" href="index.php?page=dashboard">
          <span class="nav-icon">
            <i class="bi bi-speedometer2"></i>
          </span>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link d-flex align-items-center gap-2 <?php echo ($currentPage === 'terrains') ? 'active' : ''; ?>" href="index.php?page=terrains">
          <span class="nav-icon">
            <i class="bi bi-geo-alt"></i>
          </span>
          <span>Terrains</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link d-flex align-items-center gap-2 <?php echo ($currentPage === 'tournois') ? 'active' : ''; ?>" href="index.php?page=tournois">
          <span class="nav-icon">
            <i class="bi bi-trophy"></i>
          </span>
          <span>Tournois</span>
        </a>
      </li>
    </ul>
  </div>
</div>

<!-- Two-section navbar styles -->
<style>
/* Top Section: Brand & Profile */
.navbar {
  background: rgba(255, 255, 255, 0.95) !important;
  backdrop-filter: blur(10px);
  border-bottom: 1px solid rgba(40, 167, 69, 0.1);
  padding: 0.75rem 0;
  z-index: 1030;
  position: relative;
}

/* Brand Styling */
.brand-icon {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #28a745, #2ecc71);
  border-radius: 50%;
  color: white;
  font-size: 1.2rem;
  transition: transform 0.3s ease;
}

.navbar-brand:hover .brand-icon {
  transform: scale(1.1);
}

.brand-text {
  font-size: 1.2rem;
  font-weight: 700;
  letter-spacing: -0.5px;
  color: #28a745;
}

/* Profile Section */
.profile-link {
  padding: 8px 12px;
  border-radius: 12px;
  transition: all 0.3s ease;
  text-decoration: none;
}

.profile-link:hover {
  background: rgba(40, 167, 69, 0.1);
  transform: translateY(-1px);
}

.profile-name {
  font-weight: 500;
  color: #495057;
}

/* Avatar */
.avatar {
  width: 36px;
  height: 36px;
  font-weight: 600;
  line-height: 36px;
  text-transform: uppercase;
  background: linear-gradient(135deg, #28a745, #2ecc71) !important;
  transition: all 0.3s ease;
}

.avatar:hover {
  transform: scale(1.05);
}

/* Notification Badge */
.notif-badge {
  display: inline-block;
  min-width: 18px;
  height: 18px;
  padding: 0 5px;
  font-size: 11px;
  color: #fff;
  background: linear-gradient(135deg, #dc3545, #e74c3c);
  border-radius: 999px;
  position: absolute;
  top: 6px;
  right: 6px;
  text-align: center;
  line-height: 18px;
  font-weight: 600;
  box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
}

/* Navigation Links */
.nav-link {
  color: #495057 !important;
  transition: all 0.3s ease;
}

.nav-link:hover {
  color: #28a745 !important;
}

/* Enhanced Dropdowns */
.dropdown {
  position: relative;
}

.dropdown-menu {
  border: none;
  border-radius: 12px;
  padding: 8px 0;
  margin-top: 8px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
  backdrop-filter: blur(10px);
  background: rgba(255, 255, 255, 0.95);
  z-index: 1050 !important;
  position: absolute;
  min-width: 200px;
}

.dropdown-header {
  padding: 12px 16px;
  background: rgba(40, 167, 69, 0.05);
  border-bottom: 1px solid rgba(40, 167, 69, 0.1);
  font-weight: 600;
  color: #28a745;
}

.dropdown-item {
  padding: 12px 16px;
  transition: all 0.3s ease;
  border-radius: 0;
}

.dropdown-item:hover {
  background: rgba(40, 167, 69, 0.1);
  color: #28a745;
  transform: translateX(4px);
}

/* Bottom Section: Navigation Menu */
.sub-navbar {
  background: linear-gradient(to right, rgba(255,255,255,0.95), rgba(248,252,248,0.95), rgba(255,255,255,0.95));
  backdrop-filter: blur(10px);
  border-bottom: 1px solid rgba(40, 167, 69, 0.1);
  margin-bottom: 1rem;
  z-index: 1020;
  position: relative;
}

.nav-pills {
  padding: 0.75rem 0;
  gap: 0.5rem;
}

.nav-pills .nav-link {
  color: #495057;
  padding: 0.7rem 1.2rem;
  border-radius: 1rem;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  font-weight: 500;
  background: transparent;
  text-decoration: none;
}

.nav-pills .nav-link:hover {
  color: #28a745;
  transform: translateY(-1px);
  background: rgba(40, 167, 69, 0.1);
}

.nav-pills .nav-link.active {
  background: linear-gradient(135deg, #28a745, #2ecc71);
  color: white;
  box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
}

.nav-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 1.1rem;
  transition: transform 0.3s ease;
}

.nav-pills .nav-link:hover .nav-icon {
  transform: scale(1.2);
}

.nav-pills .nav-link.active .nav-icon {
  transform: scale(1.1);
}

/* Responsive Design */
@media (max-width: 768px) {
  .navbar {
    padding: 0.5rem 0;
  }
  
  .brand-text {
    font-size: 1rem;
  }
  
  .brand-icon {
    width: 28px;
    height: 28px;
    font-size: 1rem;
  }
  
  .nav-pills {
    padding: 0.5rem 0;
  }
  
  .nav-pills .nav-link {
    padding: 0.5rem 1rem;
    font-size: 0.95rem;
  }
  
  .nav-icon {
    font-size: 1rem;
  }
}

/* Animation for smooth transitions */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.dropdown-menu.show {
  animation: fadeInUp 0.3s ease;
}
</style>

<!-- small script to remove notif badge when dropdown opened (optional UX) -->
<script>
  document.addEventListener('DOMContentLoaded', function(){
    var notifToggle = document.getElementById('notifDropdown');
    if(notifToggle){
      notifToggle.addEventListener('show.bs.dropdown', function(){
        var badge = document.querySelector('.notif-badge');
        if(badge) badge.style.display = 'none';
      });
    }
  });
</script>
