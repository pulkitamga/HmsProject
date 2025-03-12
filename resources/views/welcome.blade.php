<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Medicare Hospital Management</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <style>
    /* Navigation Custom Styles */
    nav {
      background: transparent !important;
      transition: background-color 0.3s ease;
    }
    nav.scrolled {
      background-color: #2c3e50 !important;
    }
    .navbar-nav .nav-link {
      color: #ffc905 !important;
      border-bottom: 2px solid transparent;
      transition: border-bottom 0.3s ease;
      margin: 0 10px;
    }
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      color: #ffffff !important;
      border-bottom: 2px solid #ffc905;
    }
    
    /* Other existing CSS styles */
    .hero-section {
      background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
                  url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
      background-size: cover;
      background-position: center;
      height: 100vh;
      color: white;
    }
    
    .nav-logo {
      width: 150px;
      height: auto;
      color: #ffc905;
      font-size: 20px;
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }
    
    .hero-content {
      max-width: 800px;
      margin: auto;
      text-align: center;
      padding-top: 20vh;
    }
    
    .features-section {
      padding: 80px 0;
    }
    
    .service-btn {
      background: none;
      border: 2px solid #ffc905;
      color: #fff;
      padding: 10px 35px;
      border-radius: 8px;
      font-size: 15px;
    }
    
    .service-btn:hover {
      background: #ffc905;
      color: #fff;
    }
    
    .doctor-card {
      transition: 0.5s;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .doctor-card:hover {
      transform: translateY(-10px);
    }
    
    .slider-container {
      position: relative;
      overflow: hidden;
      padding: 40px 0;
    }
    
    .slider-wrapper {
      display: flex;
      gap: 15px;
      transition: transform 0.5s ease-in-out;
    }
    
    .slider-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0, 0, 0, 0.5);
      color: white;
      border: none;
      padding: 10px;
      cursor: pointer;
      z-index: 10;
    }
    
    .prev-btn {
      left: 10px;
    }
    
    .next-btn {
      right: 10px;
    }
    
    footer {
      background: #2c3e50;
      color: white;
      padding: 50px 0;
      margin-top: 50px;
    }
    
    .appointment-form input,
    .appointment-form select {
      margin-bottom: 15px;
    }
    
    .appointment-section {
      background: url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
    }
    
    .appointment-section img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }
    
    .appointment-section form {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .appointment-section h2 {
      font-size: 24px;
      font-weight: bold;
      text-align: center;
      color: #333;
    }
    
    .appointment-section .form-control,
    .appointment-section .form-select {
      border-radius: 5px;
      border: 1px solid #ccc;
      padding: 10px;
    }
    
    /* Override Bootstrap primary button to use #ffc905 */
    .btn-primary {
      background: #ffc905 !important;
      border: none !important;
      color: #fff !important;
    }
    
    .btn-primary:hover {
      background: #e6b800 !important;
      color: #fff !important;
    }
  </style>
</head>
<body>
  
  <!-- Navigation -->
  <nav id="navbar" class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">
        <span class="nav-logo">Hospital Management</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
              <a class="nav-link active" href="#">Home</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="#">Doctors</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="{{route('login')}}">
                <i class="fa fa-user" aria-hidden="true"></i> Login
              </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">
      <div class="hero-content">
        <h1 class="display-4 mb-4" style="font-size: 90px; font-weight: bolder; color:#ffc905;">Welcome to Medicare Hospital</h1>
        <p class="lead mb-4">Advanced Healthcare Solutions with Compassionate Care</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
          <button class="service-btn">Our Services</button>
        </div>
      </div>
    </div>
  </section>
  
  <!-- Doctors Section -->
  <section class="slider-container">
    <div class="container">
      <h2 class="text-center mb-5">Our Specialist Doctors</h2>
      <!-- Wrapper with relative positioning to contain buttons and slider -->
      <div style="position: relative; overflow: hidden;">
        <!-- Slider Wrapper: Flex container showing doctor cards -->
        <div class="slider-wrapper d-flex" id="doctorSlider" style="transition: transform 0.5s ease-in-out;">
          <!-- Doctor Card 1 -->
          <div class="doctor-card me-4" style="flex: 0 0 calc(25% - 15px);">
            <div class="card">
              <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d" class="card-img-top" alt="Doctor">
              <div class="card-body text-center">
                <h5 class="card-title">Dr. Ramesh Sharma</h5>
                <p class="text-muted">Cardiology Specialist</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#appointmentModal">Book Appointment</button>
              </div>
            </div>
          </div>
          <!-- Doctor Card 2 -->
          <div class="doctor-card me-4" style="flex: 0 0 calc(25% - 15px);">
            <div class="card">
              <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d" class="card-img-top" alt="Doctor">
              <div class="card-body text-center">
                <h5 class="card-title">Dr. Priya Singh</h5>
                <p class="text-muted">Neurology Specialist</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#appointmentModal">Book Appointment</button>
              </div>
            </div>
          </div>
          <!-- Doctor Card 3 -->
          <div class="doctor-card me-4" style="flex: 0 0 calc(25% - 15px);">
            <div class="card">
              <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d" class="card-img-top" alt="Doctor">
              <div class="card-body text-center">
                <h5 class="card-title">Dr. Anil Kumar</h5>
                <p class="text-muted">Orthopedic Specialist</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#appointmentModal">Book Appointment</button>
              </div>
            </div>
          </div>
          <!-- Doctor Card 4 -->
          <div class="doctor-card me-4" style="flex: 0 0 calc(25% - 15px);">
            <div class="card">
              <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d" class="card-img-top" alt="Doctor">
              <div class="card-body text-center">
                <h5 class="card-title">Dr. Sunita Verma</h5>
                <p class="text-muted">Pediatric Specialist</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#appointmentModal">Book Appointment</button>
              </div>
            </div>
          </div>
          <!-- Additional doctor cards can be added here -->
        </div>
        <!-- Navigation Buttons inside the container -->
        <button class="slider-btn prev-btn" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%);">&#10094;</button>
        <button class="slider-btn next-btn" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%);">&#10095;</button>
      </div>
    </div>
  </section>
  
  <!-- Appointment Modal -->
  <div class="modal fade" id="appointmentModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Book Appointment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form class="appointment-form">
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Full Name" required>
            </div>
            <div class="mb-3">
              <input type="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
              <input type="tel" class="form-control" placeholder="Phone Number" required>
            </div>
            <div class="mb-3">
              <select class="form-select" required>
                <option value="">Select Doctor</option>
                <option>Dr. Ramesh Sharma</option>
                <option>Dr. Priya Singh</option>
              </select>
            </div>
            <div class="mb-3">
              <input type="date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Appointment Section -->
  <section class="appointment-section py-5">
    <div class="container">
      <div class="row align-items-center">
        <!-- Image Section -->
        <div class="col-md-6 text-center">
            <h2 style="color: #e6b800">Welcome to Our Clinic</h2>
            <p class="text-white">Experience world-class healthcare with our team of expert doctors and friendly staff. We are dedicated to your well-being and committed to delivering personalized care tailored to your needs.</p>
            <p class="text-white">Book your appointment today and take the first step towards a healthier future. We look forward to serving you!</p>
        </div>
        <!-- Form Section -->
        <div class="col-md-6">
          <h2 class="text-center mb-4" style="color: #e6b800">Book an Appointment</h2>
          <form class="p-4 border rounded shadow">
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Full Name" required>
            </div>
            <div class="mb-3">
              <input type="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
              <input type="tel" class="form-control" placeholder="Phone Number" required>
            </div>
            <div class="mb-3">
              <select class="form-select" required>
                <option value="">Select Doctor</option>
                <option>Dr. Ramesh Sharma</option>
                <option>Dr. Priya Singh</option>
              </select>
            </div>
            <div class="mb-3">
              <input type="date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </section>
  
  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h4>Contact Us</h4>
          <p><i class="fas fa-map-marker-alt"></i> 123 Medical Street, Mumbai</p>
          <p><i class="fas fa-phone"></i> +91 98765 43210</p>
          <p><i class="fas fa-envelope"></i> info@medicare.com</p>
        </div>
        <div class="col-md-4">
          <h4>Quick Links</h4>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white">About Us</a></li>
            <li><a href="#" class="text-white">Services</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h4>Opening Hours</h4>
          <p>Mon-Sat: 8:00 AM - 8:00 PM</p>
          <p>Sunday: Emergency Only</p>
        </div>
      </div>
    </div>
  </footer>
  
  <script>
    // Slider functionality
    let slider = document.getElementById('doctorSlider');
    let scrollAmount = 0;
  
    document.querySelector('.next-btn').addEventListener('click', function() {
      if (scrollAmount < slider.scrollWidth - slider.clientWidth) {
        scrollAmount += 250;
        slider.style.transform = `translateX(-${scrollAmount}px)`;
      }
    });
  
    document.querySelector('.prev-btn').addEventListener('click', function() {
      if (scrollAmount > 0) {
        scrollAmount -= 250;
        slider.style.transform = `translateX(-${scrollAmount}px)`;
      }
    });
    
    // Toggle navbar background on scroll using a CSS class
    window.addEventListener('scroll', function() {
      const navbar = document.getElementById('navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  </script>
  
  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
