<!-- Vertical Sidebar Navigation -->
<nav class="sidebar-nav">
  <div class="sidebar-header">
    <a class="sidebar-brand d-flex align-items-center gap-2" href="index.php">
      <div class="brand-icon">
        <i class="bi bi-circle-fill"></i>
      </div>
      <span class="brand-text">Book<span class="text-dark">&</span>Play</span>
    </a>
  </div>

  <div class="sidebar-content">
    <!-- User Profile Section -->
    <div class="user-profile">
      <div class="user-avatar">
        <?php 
          $userName = isset($userName) ? $userName : (isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Manager');
          echo strtoupper(substr($userName,0,1)); 
        ?>
      </div>
      <div class="user-info">
        <div class="user-name"><?php echo htmlspecialchars($userName); ?></div>
        <div class="user-role">Administrateur</div>
      </div>
    </div>

    <!-- Navigation Menu -->
    <ul class="nav nav-pills flex-column">
      <li class="nav-item">
        <a class="nav-link <?php echo ($currentPage === 'dashboard') ? 'active' : ''; ?>" href="index.php?page=dashboard">
          <i class="bi bi-speedometer2 nav-icon"></i>
          <span class="nav-text">Tableau de bord</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link <?php echo ($currentPage === 'gestionnaires') ? 'active' : ''; ?>" href="index.php?page=gestionnaires">
          <i class="bi bi-geo-alt nav-icon"></i>
          <span class="nav-text">Gestionnaire</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link <?php echo ($currentPage === 'mail') ? 'active' : ''; ?>" href="index.php?page=mail">
          <i class="bi bi-envelope nav-icon"></i>
          <span class="nav-text">Mail</span>
        </a>
      </li>
    </ul>
  </div>

  <!-- Footer Section -->
  <div class="sidebar-footer">
    <div class="dropdown">
      <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="user-avatar-small">
          <?php echo strtoupper(substr($userName,0,1)); ?>
        </div>
        <span class="user-name-small"><?php echo htmlspecialchars($userName); ?></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="profileDropdown">
        <li><a class="dropdown-item" href="index.php?page=profile"><i class="bi bi-person me-2"></i>Profile</a></li>
        <li><a class="dropdown-item" href="index.php?page=settings"><i class="bi bi-gear me-2"></i>Settings</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="/BOOK-PLAY/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Vertical Sidebar Styles -->
<style>
/* Sidebar Container */
.sidebar-nav {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 280px;
  background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(248,252,248,0.95));
  backdrop-filter: blur(10px);
  border-right: 1px solid rgba(40, 167, 69, 0.1);
  z-index: 1000;
  display: flex;
  flex-direction: column;
  box-shadow: 2px 0 20px rgba(0, 0, 0, 0.1);
}

/* Sidebar Header */
.sidebar-header {
  padding: 1.5rem 1.25rem;
  border-bottom: 1px solid rgba(40, 167, 69, 0.1);
  background: rgba(40, 167, 69, 0.05);
}

.sidebar-brand {
  text-decoration: none;
  color: #28a745;
  font-weight: 700;
  font-size: 1.1rem;
  transition: all 0.3s ease;
}

.sidebar-brand:hover {
  color: #28a745;
  transform: translateX(2px);
}

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

.sidebar-brand:hover .brand-icon {
  transform: scale(1.1);
}

.brand-text {
  font-size: 1.1rem;
  font-weight: 700;
  letter-spacing: -0.5px;
}

/* Sidebar Content */
.sidebar-content {
  flex: 1;
  padding: 1.5rem 0;
  overflow-y: auto;
}

/* User Profile Section */
.user-profile {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 0 1.25rem 1.5rem;
  margin-bottom: 1rem;
  border-bottom: 1px solid rgba(40, 167, 69, 0.1);
}

.user-avatar {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, #28a745, #2ecc71);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  font-size: 1.2rem;
  text-transform: uppercase;
  box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
}

.user-info {
  flex: 1;
}

.user-name {
  font-weight: 600;
  color: #495057;
  font-size: 1rem;
  margin-bottom: 0.25rem;
}

.user-role {
  font-size: 0.85rem;
  color: #28a745;
  font-weight: 500;
  background: rgba(40, 167, 69, 0.1);
  padding: 0.25rem 0.5rem;
  border-radius: 12px;
  display: inline-block;
}

/* Navigation Menu */
.nav {
  padding: 0 1rem;
}

.nav-item {
  margin-bottom: 0.5rem;
}

.nav-link {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.875rem 1rem;
  color: #495057;
  text-decoration: none;
  border-radius: 12px;
  transition: all 0.3s ease;
  font-weight: 500;
  position: relative;
  overflow: hidden;
}

.nav-link:hover {
  color: #28a745;
  background: rgba(40, 167, 69, 0.1);
  transform: translateX(4px);
}

.nav-link.active {
  background: linear-gradient(135deg, #28a745, #2ecc71);
  color: white;
  box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
  transform: translateX(4px);
}

.nav-icon {
  font-size: 1.1rem;
  width: 20px;
  text-align: center;
  transition: transform 0.3s ease;
}

.nav-link:hover .nav-icon {
  transform: scale(1.2);
}

.nav-link.active .nav-icon {
  transform: scale(1.1);
}

.nav-text {
  font-size: 0.95rem;
  font-weight: 500;
}

/* Sidebar Footer */
.sidebar-footer {
  padding: 1.25rem;
  border-top: 1px solid rgba(40, 167, 69, 0.1);
  background: rgba(40, 167, 69, 0.02);
}

.user-avatar-small {
  width: 32px;
  height: 32px;
  background: linear-gradient(135deg, #28a745, #2ecc71);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  font-size: 0.9rem;
  text-transform: uppercase;
}

.user-name-small {
  font-weight: 500;
  color: #495057;
  font-size: 0.9rem;
}

/* Dropdown Styles */
.dropdown-menu {
  border: none;
  border-radius: 12px;
  padding: 8px 0;
  margin-top: 8px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
  backdrop-filter: blur(10px);
  background: rgba(255, 255, 255, 0.95);
  z-index: 1050;
  min-width: 200px;
}

.dropdown-item {
  padding: 12px 16px;
  transition: all 0.3s ease;
  color: #495057;
}

.dropdown-item:hover {
  background: rgba(40, 167, 69, 0.1);
  color: #28a745;
  transform: translateX(4px);
}

/* Responsive Design */
@media (max-width: 768px) {
  .sidebar-nav {
    width: 100%;
    transform: translateX(-100%);
    transition: transform 0.3s ease;
  }
  
  .sidebar-nav.show {
    transform: translateX(0);
  }
  
  .sidebar-header {
    padding: 1rem;
  }
  
  .sidebar-content {
    padding: 1rem 0;
  }
  
  .user-profile {
    padding: 0 1rem 1rem;
  }
  
  .nav {
    padding: 0 0.75rem;
  }
}

/* Animation for smooth transitions */
@keyframes slideInLeft {
  from {
    opacity: 0;
    transform: translateX(-20px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

.nav-link {
  animation: slideInLeft 0.3s ease;
}

/* Scrollbar Styling */
.sidebar-content::-webkit-scrollbar {
  width: 4px;
}

.sidebar-content::-webkit-scrollbar-track {
  background: rgba(40, 167, 69, 0.1);
  border-radius: 2px;
}

.sidebar-content::-webkit-scrollbar-thumb {
  background: rgba(40, 167, 69, 0.3);
  border-radius: 2px;
}

.sidebar-content::-webkit-scrollbar-thumb:hover {
  background: rgba(40, 167, 69, 0.5);
}
</style>

<!-- Mobile Toggle Button (for responsive) -->
<button class="sidebar-toggle d-lg-none" type="button" onclick="toggleSidebar()">
  <i class="bi bi-list"></i>
</button>

<style>
.sidebar-toggle {
  position: fixed;
  top: 1rem;
  left: 1rem;
  z-index: 1100;
  background: linear-gradient(135deg, #28a745, #2ecc71);
  color: white;
  border: none;
  border-radius: 8px;
  padding: 0.5rem;
  font-size: 1.2rem;
  box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
  transition: all 0.3s ease;
}

.sidebar-toggle:hover {
  transform: scale(1.05);
  box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
}

@media (min-width: 769px) {
  .sidebar-toggle {
    display: none;
  }
}
</style>

<script>
function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar-nav');
  sidebar.classList.toggle('show');
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
  const sidebar = document.querySelector('.sidebar-nav');
  const toggle = document.querySelector('.sidebar-toggle');
  
  if (window.innerWidth <= 768 && 
      !sidebar.contains(event.target) && 
      !toggle.contains(event.target)) {
    sidebar.classList.remove('show');
  }
});
</script>
