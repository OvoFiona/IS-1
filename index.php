<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strathmore Lost & Found System</title>
    <link rel="stylesheet" href="CSS/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
          
    </head>
<body>
   <?php include_once("templates/nav.php"); ?> 
    <header class="head-container">
        <img src="Images/strathmore logo.png" alt="Strathmore University Logo" class="logo"><br>
    </header>    

    <h1>Strathmore Lost & Found System</h1>

    <div class="image-container">
        <img src="Images/lost and found.png" alt="Lost and Found Icon" class="icon">
     </div>
     
    <section id="Home">
       <p>Welcome to the Strathmore Lost & Found System.</p>
       <p>This system is designed to help you report and retrieve lost items.</p>
       <p>Find your lost items quickly and easily with our automated platform designed for the Strathmore community.</p><br>
    </section>

    <!--button-->
    <div class="button">
        <a href="studentregister.php" class="btn-primary">Student Page</a>
        <a href="SecurityGuard.php" class="btn-primary">Security guard page</a>
    </div>
    <br><br>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h2 class="display-4 fw-bold mb-4">About Our System</h2>
            <p class="lead mb-5">Learn more about the Strathmore University Lost & Found System and how it works</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="id=about container mb-5 py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="mb-4">Our Mission</h2>
                <p>The Strathmore University Lost & Found System was developed to address the challenges students and staff face when losing personal belongings on campus. Our mission is to provide a streamlined, efficient, and user-friendly platform that connects lost items with their owners quickly and securely.</p>
                <p>By leveraging modern web technologies, we've created a system that reduces the time and frustration traditionally associated with recovering lost items, while also providing valuable data to help improve campus services.</p>
            </div>
    </section>


    <!-- Contact Section -->
    <section id="contact container mb-5 py-5">
        <div class="container">
        <h1 class="display-4 fw-bold mb-4">Contact Us</h1>
        <p class="lead mb-5">Get in touch with our team for more information about our services. We'd love to hear from you and answer any questions you might have.</p>
        </div>
    </section>

        <script>
        // Highlight active navigation item while scrolling
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('nav a');
        
        window.addEventListener('scroll', () => {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                
                if (pageYOffset >= (sectionTop - 100)) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
    </script>
   
    <!-- Footer -->
    <footer>
        <div class="footer-content">
                    <h5 class="mb-3">Strathmore Lost & Found</h5>
                    <p>A secure system for reporting and recovering lost items within Strathmore University.</p>
                    <p>Developed by BBIT Students</p>
         </div>

 </footer>  
</body>
</html>        
    



