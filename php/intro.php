<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Meri Gaddi Family Service</title>
  <style>
    /* Global Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
      background-color: #f8f9fa;
      color: #333;
      line-height: 1.6;
    }
    
    /* Header */
    header {
      background: linear-gradient(135deg, #1e5799 0%, #207cca 100%);
      color: white;
      text-align: center;
      padding: 2rem 0;
    }
    
    .logo {
      font-size: 2.5rem;
      font-weight: bold;
      margin-bottom: 1rem;
    }
    
    .tagline {
      font-size: 1.2rem;
      opacity: 0.9;
    }
    
    /* Main Content */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem 1rem;
    }
    
    /* About Section */
    .about-section {
      background-color: white;
      border-radius: 8px;
      padding: 2rem;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
    }
    
    h2 {
      color: #1e5799;
      margin-bottom: 1.5rem;
      font-size: 1.8rem;
    }
    
    .highlight {
      background-color: #f0f7ff;
      border-left: 4px solid #1e5799;
      padding: 1rem;
      margin: 1.5rem 0;
    }
    
    /* Services */
    .services {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      justify-content: space-between;
      margin: 2rem 0;
    }
    
    .service-card {
      flex: 1 1 300px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      padding: 1.5rem;
      transition: transform 0.3s;
    }
    
    .service-card:hover {
      transform: translateY(-5px);
    }
    
    .service-icon {
      background-color: #1e5799;
      color: white;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      margin-bottom: 1.2rem;
    }
    
    .service-title {
      font-size: 1.3rem;
      margin-bottom: 0.8rem;
      color: #333;
    }
    
    /* Team Section */
    .team-section {
      background-color: white;
      border-radius: 8px;
      padding: 2rem;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
    }
    
    .team-members {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      justify-content: center;
      margin-top: 2rem;
    }
    
    .team-member {
      text-align: center;
      flex: 1 1 200px;
      max-width: 250px;
    }
    
    .member-img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #1e5799;
      margin-bottom: 1rem;
    }
    
    .member-name {
      font-size: 1.2rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
    }
    
    .member-role {
      color: #1e5799;
      font-weight: bold;
      margin-bottom: 0.5rem;
    }
    
    /* Call to Action */
    .cta-section {
      text-align: center;
      background: linear-gradient(135deg, #1e5799 0%, #207cca 100%);
      color: white;
      padding: 3rem 2rem;
      border-radius: 8px;
    }
    
    .cta-title {
      font-size: 2rem;
      margin-bottom: 1.5rem;
      color: white;
    }
    
    .cta-button {
      display: inline-block;
      background-color: white;
      color: #1e5799;
      padding: 1rem 2rem;
      font-size: 1.2rem;
      font-weight: bold;
      border-radius: 50px;
      text-decoration: none;
      transition: all 0.3s;
      border: 2px solid white;
    }
    
    .cta-button:hover {
      background-color: transparent;
      color: white;
    }
    
    /* Footer */
    footer {
      background-color: #333;
      color: white;
      text-align: center;
      padding: 2rem 0;
      margin-top: 3rem;
    }
    
    .contact-info {
      margin-bottom: 1.5rem;
    }
    
    .social-icons {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-top: 1rem;
    }
    
    .social-icon {
      width: 40px;
      height: 40px;
      background-color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #333;
      text-decoration: none;
      transition: all 0.3s;
    }
    
    .social-icon:hover {
      background-color: #1e5799;
      color: white;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .services, .team-members {
        gap: 1rem;
      }
      
      .service-card {
        flex: 1 1 100%;
      }
    }
  </style>
</head>
<body>
  

  <!-- Main Content -->
  <div class="container">
    <!-- About Section -->
    <section class="about-section">
      <h2>Welcome to Meri Gaddi Family Service</h2>
      <p>At Meri Gaddi, we understand that your vehicle is not just a mode of transportation—it's an integral part of your family's journey through life. Founded with a passion for excellence and a commitment to customer satisfaction, we've been proudly serving families since 2015.</p>
      
      <div class="highlight">
        <p>"Meri Gaddi" means "My Car" in Hindi, and we treat your vehicle with the same care and attention as if it were our own. Our mission is to provide reliable, transparent, and family-friendly vehicle maintenance services that give you peace of mind on every journey.</p>
      </div>
      
      <p>With our team of certified technicians and state-of-the-art facilities, we offer comprehensive solutions for all your automotive needs—from routine maintenance to complex repairs. We believe in building lasting relationships with our customers through honest service, fair pricing, and exceptional workmanship.</p>
    </section>
    
    <!-- Services Section -->
    <h2>Our Services</h2>
    <div class="services">
      <div class="service-card">
        <div class="service-icon">🔧</div>
        <h3 class="service-title">Maintenance Services</h3>
        <p>Regular maintenance packages tailored for families, including oil changes, filter replacements, brake services, and multi-point inspections to keep your vehicle running smoothly.</p>
      </div>
      
      <div class="service-card">
        <div class="service-icon">⚡</div>
        <h3 class="service-title">Electrical Systems</h3>
        <p>Comprehensive electrical diagnostics and repairs, battery services, and lighting system maintenance to ensure your family's safety on the road.</p>
      </div>
      
      <div class="service-card">
        <div class="service-icon">🔄</div>
        <h3 class="service-title">Engine Services</h3>
        <p>Engine diagnostics, tune-ups, and repairs by our expert technicians using the latest technology to maximize your vehicle's performance and fuel efficiency.</p>
      </div>
    </div>
    
    <!-- Team Section -->
    <section class="team-section">
      <h2>Meet Our Family</h2>
      <p>Our team consists of passionate automotive professionals who share a common goal: to provide your family with safe, reliable, and exceptional vehicle care. Every member brings unique expertise and dedication to ensure your complete satisfaction.</p>
      
      <div class="team-members">
        <div class="team-member">
          <img src="/api/placeholder/150/150" alt="Team Member" class="member-img" />
          <h3 class="member-name">Rahul Sharma</h3>
          <p class="member-role">Founder & Chief Technician</p>
          <p>With over 15 years of experience, Rahul leads our team with passion and expertise.</p>
        </div>
        
        <div class="team-member">
          <img src="/api/placeholder/150/150" alt="Team Member" class="member-img" />
          <h3 class="member-name">Priya Patel</h3>
          <p class="member-role">Customer Relations Manager</p>
          <p>Priya ensures every family receives personalized care and attention throughout their service experience.</p>
        </div>
        
        <div class="team-member">
          <img src="/api/placeholder/150/150" alt="Team Member" class="member-img" />
          <h3 class="member-name">Amit Singh</h3>
          <p class="member-role">Senior Mechanic</p>
          <p>Specialized in diagnostics and complex repairs, Amit solves even the most challenging vehicle issues.</p>
        </div>
        
        <div class="team-member">
          <img src="/api/placeholder/150/150" alt="Team Member" class="member-img" />
          <h3 class="member-name">Neha Gupta</h3>
          <p class="member-role">Service Advisor</p>
          <p>Neha helps families understand their vehicle needs and guides them through service options.</p>
        </div>
      </div>
    </section>
    
    <!-- Call to Action Section -->
    <section class="cta-section">
      <h2 class="cta-title">Ready to Experience the Meri Gaddi Difference?</h2>
      <p>Schedule your appointment today and join the thousands of satisfied families who trust us with their vehicles.</p>
      <a href="#" class="cta-button">Book An Appointment</a>
    </section>
  </div>
  
  
</body>
</html>