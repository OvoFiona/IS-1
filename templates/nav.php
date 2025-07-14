<!-- Navigation -->
<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav style="position: fixed; top: 0; width: 100%; background-color: #2c3e50; padding: 10px 20px; z-index: 1000; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); min-height: 60px;">
  <div style="display: flex; align-items: center; justify-content: space-between; max-width: 1200px; margin: 0 auto;">
    
    <!-- Left: Logo -->
    <div style="flex-shrink: 0;">
      <img src="Images/strathmore logo.png" alt="Strathmore University Logo" style="height: 40px; width: auto; border-radius: 6px;">
    </div>
    
    <!-- Center: Navigation Links -->
    <ul style="display: flex; justify-content: center; list-style: none; margin: 0; padding: 0; flex-grow: 1;">
      <li style="margin: 0 15px;">
        <a href="index.php" style="color: white; text-decoration: none; font-size: 18px; padding: 8px 16px; border-radius: 4px; transition: background-color 0.3s ease; <?= $currentPage === 'index.php' ? 'background-color: #3498db;' : '' ?>" onmouseover="if(this.style.backgroundColor !== 'rgb(52, 152, 219)') this.style.backgroundColor = '#34495e';" onmouseout="if(this.style.backgroundColor !== 'rgb(52, 152, 219)') this.style.backgroundColor = 'transparent';">
          Home
        </a>
      </li>
      <li style="margin: 0 15px;">
        <a href="about.php" style="color: white; text-decoration: none; font-size: 18px; padding: 8px 16px; border-radius: 4px; transition: background-color 0.3s ease; <?= $currentPage === 'about.php' ? 'background-color: #3498db;' : '' ?>" onmouseover="if(this.style.backgroundColor !== 'rgb(52, 152, 219)') this.style.backgroundColor = '#34495e';" onmouseout="if(this.style.backgroundColor !== 'rgb(52, 152, 219)') this.style.backgroundColor = 'transparent';">
          About
        </a>
      </li>
      <li style="margin: 0 15px;">
        <a href="contactus.php" style="color: white; text-decoration: none; font-size: 18px; padding: 8px 16px; border-radius: 4px; transition: background-color 0.3s ease; <?= $currentPage === 'contactus.php' ? 'background-color: #3498db;' : '' ?>" onmouseover="if(this.style.backgroundColor !== 'rgb(52, 152, 219)') this.style.backgroundColor = '#34495e';" onmouseout="if(this.style.backgroundColor !== 'rgb(52, 152, 219)') this.style.backgroundColor = 'transparent';">
          Contact
        </a>
      </li>
    </ul>
    
    <!-- Right: User Icon -->
    <div onclick="openPanel()" style="cursor: pointer; flex-shrink: 0; padding: 8px;">
      <span style="font-size: 28px; color: white; transition: color 0.3s ease;" onmouseover="this.style.color = '#3498db';" onmouseout="this.style.color = 'white';">👤</span>
    </div>
  </div>
</nav>

<!-- Overlay -->
<div id="overlay" onclick="closePanel()" style="
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 100vw;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1099;
  opacity: 0;
  transition: opacity 0.3s ease;
"></div>

<!-- Slide-in Panel from Right -->
<div id="sidePanel" style="
  height: 350px;
  width: 0;
  position: fixed;
  top: 0;
  right: 0;
  background-color: #34495e;
  overflow-x: hidden;
  transition: width 0.3s ease;
  padding-top: 60px;
  z-index: 1100;
  box-shadow: -2px 0 10px rgba(0, 0, 0, 0.3);
">
  <!-- Close Button -->
  <a href="javascript:void(0)" onclick="closePanel()" style="
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 32px;
    color: white;
    text-decoration: none;
    transition: color 0.3s ease;
  " onmouseover="this.style.color = '#e74c3c';" onmouseout="this.style.color = 'white';">&times;</a>
  
  <!-- Button Links -->
  <div style="display: flex; flex-direction: column; align-items: center; gap: 20px; margin-top: 30px; padding: 0 20px;">
    <a href="studentregister.php" style="
      background-color: #3498db;
      color: white;
      padding: 15px 30px;
      border-radius: 5px;
      text-decoration: none;
      font-size: 16px;
      width: 200px;
      text-align: center;
      transition: background-color 0.3s ease;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    " onmouseover="this.style.backgroundColor = '#2980b9';" onmouseout="this.style.backgroundColor = '#3498db';">
      Student Page
    </a>
    
    <a href="SecurityGuard.php" style="
      background-color: #e67e22;
      color: white;
      padding: 15px 30px;
      border-radius: 5px;
      text-decoration: none;
      font-size: 16px;
      width: 200px;
      text-align: center;
      transition: background-color 0.3s ease;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    " onmouseover="this.style.backgroundColor = '#d35400';" onmouseout="this.style.backgroundColor = '#e67e22';">
      Security Guard Page
    </a>

    <a href="adminsignup.php" style="
      background-color: #e6229bff;
      color: white;
      padding: 15px 30px;
      border-radius: 5px;
      text-decoration: none;
      font-size: 16px;
      width: 200px;
      text-align: center;
      transition: background-color 0.3s ease;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    " onmouseover="this.style.backgroundColor = '#d35400';" onmouseout="this.style.backgroundColor = '#e67e22';">
      Admin Page
    </a>
  </div>
</div>

<script>
  function openPanel() {
    const panel = document.getElementById("sidePanel");
    const overlay = document.getElementById("overlay");
    
    panel.style.width = "280px";
    overlay.style.display = "block";
    
    // Trigger opacity transition after display is set
    setTimeout(() => {
      overlay.style.opacity = "1";
    }, 10);
  }
  
  function closePanel() {
    const panel = document.getElementById("sidePanel");
    const overlay = document.getElementById("overlay");
    
    panel.style.width = "0";
    overlay.style.opacity = "0";
    
    // Hide overlay after transition completes
    setTimeout(() => {
      overlay.style.display = "none";
    }, 300);
  }
  
  // Close panel when clicking outside
  document.addEventListener('click', function(event) {
    const panel = document.getElementById("sidePanel");
    const userIcon = event.target.closest('[onclick="openPanel()"]');
    
    if (!panel.contains(event.target) && !userIcon && panel.style.width !== "0px" && panel.style.width !== "") {
      closePanel();
    }
  });
</script>

<!-- Add responsive styles -->
<style>
  @media (max-width: 768px) {
    nav ul {
      display: none !important;
    }
    
    nav div:first-child {
      justify-content: space-between !important;
    }
  }
  
  @media (min-width: 769px) and (max-width: 1024px) {
    nav ul li {
      margin: 0 10px !important;
    }
    
    nav ul li a {
      font-size: 16px !important;
      padding: 6px 12px !important;
    }
  }
</style>