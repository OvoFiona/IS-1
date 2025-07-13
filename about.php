<!-- About Page for Strathmore Lost & Found System -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About - Strathmore Lost & Found System</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom Styles for About Page -->
  <style>
    .hero-section {
      background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
      color: white;
      padding: 100px 0;
      margin-top: 67px;
    }
    
    .feature-card {
      background: white;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      height: 100%;
    }
    
    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .feature-icon {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, #3498db, #2980b9);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      color: white;
      margin: 0 auto 20px;
    }
    
    .stat-card {
      background: linear-gradient(135deg, #e74c3c, #c0392b);
      color: white;
      padding: 30px;
      border-radius: 15px;
      text-align: center;
      transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
      transform: scale(1.05);
    }
    
    .stat-number {
      font-size: 3rem;
      font-weight: bold;
      margin-bottom: 10px;
    }
    
    .team-card {
      background: white;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      text-align: center;
    }
    
    .team-card:hover {
      transform: translateY(-5px);
    }
    
    .team-image {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      margin: 0 auto 20px;
      border: 4px solid #3498db;
    }
    
    .timeline {
      position: relative;
      padding-left: 30px;
    }
    
    .timeline::before {
      content: '';
      position: absolute;
      left: 15px;
      top: 0;
      bottom: 0;
      width: 2px;
      background: #3498db;
    }
    
    .timeline-item {
      position: relative;
      margin-bottom: 30px;
      padding-left: 40px;
    }
    
    .timeline-item::before {
      content: '';
      position: absolute;
      left: -8px;
      top: 5px;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      background: #3498db;
      border: 3px solid white;
      box-shadow: 0 0 0 3px #3498db;
    }
    
    .process-step {
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      border-radius: 15px;
      padding: 30px;
      text-align: center;
      position: relative;
      margin-bottom: 30px;
    }
    
    .process-number {
      position: absolute; 
      top: -20px; 
      left: 50%;
      transform: translateX(-50%);
      width: 40px;
      height: 40px;
      background: #3498db;
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 1.2rem;
    }
    
    .placeholder-image {
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      border: 2px dashed #dee2e6;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #6c757d;
      font-size: 1.1rem;
      min-height: 200px;
    }
    
    .section-divider {
      height: 2px;
      background: linear-gradient(90deg, transparent, #3498db, transparent);
      margin: 60px 0;
    }
  </style>
</head>
<body>
  <!-- Navigation Bar -->
  <?php include_once("templates/nav.php"); ?>
  
  <!-- Hero Section: Main intro and campus image -->
  <section class="hero-section text-center">
    <div class="container">
      <h1 class="display-3 fw-bold mb-4">About Our System</h1>
      <p class="lead mb-5 fs-4">Connecting lost items with their owners through innovative technology</p>
      
    </div>
  </section>
  
  <!-- Mission & Vision Section: Purpose and future goals -->
  <section class="py-5">
    <div class="container">
      <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h2 class="display-5 fw-bold mb-4 text-primary">Our Mission</h2>
          <p class="fs-5 mb-4">The Strathmore University Lost & Found System was developed to address the challenges students face when losing personal belongings on campus. Our mission is to provide a streamlined, efficient, and user-friendly platform that connects lost items with their owners quickly and securely.</p>
          <p class="fs-6">By leveraging modern web technologies, we've created a system that reduces the time and frustration traditionally associated with recovering lost items, while also providing valuable data to help improve campus services.</p>
        </div>
        <div class="col-lg-6">
          <div class="placeholder-image">
            <!-- Mission & Vision Illustration -->
            <img src="https://sims.strathmore.edu/wp-content/uploads/2023/02/IMG_1913.jpg_resized-scaled.jpg" alt="Mission Vision" style="max-width:100%; max-height:180px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.08); object-fit:cover; height: 100%; width: 100%; ">
          </div>
        </div>
      </div>
      
      <div class="row align-items-center">
        <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
          <h2 class="display-5 fw-bold mb-4 text-primary">Our Vision</h2>
          <p class="fs-5 mb-4">To become the leading digital solution for lost and found management in academic institutions across Kenya and beyond, fostering a more connected and responsible campus community.</p>
          <p class="fs-6">We envision a future where losing an item on campus doesn't mean losing it forever, where technology bridges the gap between loss and recovery, and where every member of our community can contribute to making our campus a better place.</p>
        </div>
        <div class="col-lg-6 order-lg-1">
          <div class="placeholder-image">
          <img src="images/carousel3.jpeg" alt="vision" style="max-width:100%; max-height:180px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.08); object-fit:cover; height: 100%; width: 100%; ">
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <!-- Section Divider -->
  <div class="section-divider"></div>
  
  <!-- Key Features Section -->

  

  
  
  <!-- How It Works Section: Steps for users -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="display-4 fw-bold mb-4">How It Works</h2>
        <p class="lead">Simple steps to report and recover your lost items</p>
      </div>
      
      <div class="row">
        <div class="col-lg-6 mb-4">
          <div class="process-step">
            <div class="process-number">1</div>
            <h4 class="mt-3 mb-3">Report Your Lost Item</h4>
            <p>Log into the system and provide detailed information about your lost item, including description, location, and time.</p>
          </div>
        </div>
        
        <div class="col-lg-6 mb-4">
          <div class="process-step">
            <div class="process-number">2</div>
            <h4 class="mt-3 mb-3">System Matching</h4>
            <p>Our intelligent system automatically matches your lost item with found items in our database.</p>
          </div>
        </div>
        
        <div class="col-lg-6 mb-4">
          <div class="process-step">
            <div class="process-number">3</div>
            <h4 class="mt-3 mb-3">Get Notified</h4>
            <p>Receive instant notifications when potential matches are found, with detailed information and photos.</p>
          </div>
        </div>
        
        <div class="col-lg-6 mb-4">
          <div class="process-step">
            <div class="process-number">4</div>
            <h4 class="mt-3 mb-3">Claim Your Item</h4>
            <p>Verify your identity and claim your item from the designated pickup location on campus.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  
  
  <!-- Section Divider -->
  <div class="section-divider"></div>
  
  
  <!-- Call to Action Section: Portal links and contact -->
  <section class="py-5 bg-primary text-white">
    <div class="container text-center">
      <h2 class="display-4 fw-bold mb-4">Ready to Get Started?</h2>
      <p class="lead mb-4">Join thousands of students and staff who trust our system to keep their belongings safe</p>
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="studentregister.php" class="btn btn-light btn-lg">Student Portal</a>
        <a href="SecurityGuard.php" class="btn btn-outline-light btn-lg">Security Portal</a>
        <a href="contactus.php" class="btn btn-outline-light btn-lg">Contact Us</a>
      </div>
    </div>
  </section>
  
  <!-- Footer -->
  <?php include_once("templates/footer.php"); ?>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>