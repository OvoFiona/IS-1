<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Strathmore Lost & Found System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Custom styles for the carousel */
    .carousel-item {
      height: 400px;
      position: relative;
    }
    
    .carousel-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(0.6);
    }
    
    .carousel-caption {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: white;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
    }
    
    .carousel-caption h1 {
      font-size: 2.5rem;
      font-weight: bold;
      margin-bottom: 1rem;
    }
    
    /* Show caption on all screen sizes */
    .carousel-caption {
      display: block !important;
    }
    
    /* Responsive text sizing */
    @media (max-width: 768px) {
      .carousel-caption h1 {
        font-size: 1.8rem;
      }
      .carousel-item {
        height: 300px;
      }
    }
    
    @media (max-width: 576px) {
      .carousel-caption h1 {
        font-size: 1.4rem;
      }
      .carousel-item {
        height: 250px;
      }
    }
    
    /* Navigation positioning */
    .navbar-placeholder {
      height: 67px; /* Adjust based on your navbar height */
    }
    
    /* Description section styling */
    #Home {
      padding: 60px 20px;
      background-color: #f8f9fa;
    }
    
    #Home p {
      font-size: 1.2rem;
      line-height: 1.6;
      margin-bottom: 1.5rem;
      color: #333;
    }
    
    /* Carousel indicators styling */
    .carousel-indicators [data-bs-target] {
      background-color: rgba(255, 255, 255, 0.5);
    }
    
    .carousel-indicators .active {
      background-color: white;
    }
    
    /* Carousel controls styling */
    .carousel-control-prev,
    .carousel-control-next {
      width: 5%;
    }
    
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      background-size: 20px 20px;
    }
  </style>
</head>
<body>
  <!-- Navigation placeholder - replace with your actual nav -->
  <?php include_once("templates/nav.php"); ?>

  <div class="navbar-placeholder"></div>

  <!-- Carousel Section -->
  <div id="lostFoundCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
    <!-- Carousel indicators -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#lostFoundCarousel" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#lostFoundCarousel" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#lostFoundCarousel" data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=1200&h=400&fit=crop" class="d-block w-100" alt="Lost and Found Slide 1">
        <div class="carousel-caption">
          <h1>Strathmore Lost & Found System</h1>
        </div>
      </div>
      <div class="carousel-item">
        <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=1200&h=400&fit=crop" class="d-block w-100" alt="Lost and Found Slide 2">
        <div class="carousel-caption">
          <h1>Secure • Reliable • Fast</h1>
        </div>
      </div>
      <div class="carousel-item">
        <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=1200&h=400&fit=crop" class="d-block w-100" alt="Lost and Found Slide 3">
        <div class="carousel-caption">
          <h1>Report or Reclaim Items Easily</h1>
        </div>
      </div>
    </div>

    <!-- Carousel controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#lostFoundCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#lostFoundCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- Description Section -->
  <section id="Home" class="container-fluid">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <h2 class="text-center mb-4">Welcome to Strathmore Lost & Found</h2>
          <p class="text-center">Welcome to the Strathmore Lost & Found System.</p>
          <p class="text-center">This system is designed to help you report and retrieve lost items.</p>
          <p class="text-center">Find your lost items quickly and easily with our automated platform designed for the Strathmore community.</p>
        </div>
      </div>
    </div>
  </section>

  <?php include_once("templates/footer.php"); ?>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>