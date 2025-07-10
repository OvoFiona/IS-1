<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us - Strathmore Lost & Found</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include_once("templates/nav.php"); ?>

  <!-- Contact Section -->
  <section id="contact" class="container py-5" style="margin-top: 100px;">
    <div class="text-center mb-5">
      <h1 class="display-4 fw-bold">Contact Us</h1>
      <p class="lead">Get in touch with our team for more information about our services. We'd love to hear from you.</p>
    </div>

    <div class="row g-4 align-items-stretch">
      <!-- Map -->
      <div class="col-lg-6">
        <div class="h-100 rounded shadow-sm overflow-hidden">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15955.15211296604!2d36.80284811759225!3d-1.302118776628757!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f10f0142f0257%3A0x791aa8e6d8535b6b!2sKenyatta%20Hospital%2C%20Nairobi!5e0!3m2!1sen!2ske!4v1752137086176!5m2!1sen!2ske"
            width="100%" 
            height="100%" 
            style="min-height: 400px; border: 0;" 
            allowfullscreen 
            loading="lazy">
          </iframe>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="col-lg-6">
        <div class="card shadow-sm p-4 h-100">
          <h4 class="mb-4">Send Us a Message</h4>
          <form action="contact_process.php" method="POST" class="row g-3">
            <div class="col-12">
              <label for="name" class="form-label">Name</label>
              <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="col-12">
              <label for="subject" class="form-label">Subject</label>
              <input type="text" id="subject" name="subject" class="form-control" required>
            </div>

            <div class="col-12">
              <label for="message" class="form-label">Message</label>
              <textarea id="message" name="message" rows="5" class="form-control" required></textarea>
            </div>

            <div class="col-12 text-end">
              <button type="submit" class="btn btn-success px-4">Send Message</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <?php include_once("templates/footer.php"); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
