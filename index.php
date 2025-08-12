<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Insurance Management System</title>
  <style>
    /* Reset */
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    body {
      background: #f9fafb;
      color: #333;
      line-height: 1.6;
    }
    a {
      color: #2b7a78;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
    header {
      background-color: #3aafa9;
      color: white;
      padding: 1rem 2rem;
      position: sticky;
      top: 0;
      z-index: 100;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header h1 {
      font-size: 1.8rem;
      letter-spacing: 2px;
    }
    nav ul {
      list-style: none;
      display: flex;
      gap: 1.5rem;
    }
    nav ul li {
      font-weight: 600;
    }
    nav ul li a {
      color: white;
      font-size: 1rem;
    }
    nav ul li a.button {
      background: #def2f1;
      color: #3aafa9;
      padding: 0.4rem 1rem;
      border-radius: 5px;
      font-weight: 700;
    }
    nav ul li a.button:hover {
      background: #2b7a78;
      color: white;
    }
    main {
      max-width: 1100px;
      margin: 2rem auto;
      padding: 0 1rem;
    }
    /* Hero Section */
    .hero {
      text-align: center;
      padding: 4rem 1rem;
      background: linear-gradient(135deg, #17252a, #3aafa9);
      color: white;
      border-radius: 12px;
      margin-bottom: 3rem;
    }
    .hero h2 {
      font-size: 2.8rem;
      margin-bottom: 1rem;
    }
    .hero p {
      font-size: 1.2rem;
      max-width: 600px;
      margin: 0 auto 2rem auto;
    }
    .hero a.btn-primary {
      display: inline-block;
      padding: 1rem 2rem;
      background: #def2f1;
      color: #17252a;
      font-weight: 700;
      border-radius: 8px;
      font-size: 1.1rem;
      transition: background 0.3s ease;
    }
    .hero a.btn-primary:hover {
      background: #2b7a78;
      color: white;
    }

    /* Features Section */
    .features {
      display: grid;
      grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
      gap: 2rem;
      margin-bottom: 3rem;
    }
    .feature-box {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      text-align: center;
      transition: transform 0.3s ease;
    }
    .feature-box:hover {
      transform: translateY(-10px);
    }
    .feature-box h3 {
      margin-bottom: 1rem;
      color: #17252a;
    }
    .feature-box p {
      font-size: 1rem;
      color: #555;
    }

    /* About Section */
    .about {
      background: white;
      padding: 2rem 2rem;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      margin-bottom: 3rem;
    }
    .about h2 {
      margin-bottom: 1rem;
      color: #17252a;
      text-align: center;
    }
    .about p {
      max-width: 800px;
      margin: 0 auto;
      font-size: 1.1rem;
      color: #444;
      line-height: 1.7;
    }

    /* Testimonials */
    .testimonials {
      background: #def2f1;
      padding: 3rem 1rem;
      border-radius: 12px;
      margin-bottom: 3rem;
    }
    .testimonials h2 {
      text-align: center;
      margin-bottom: 2rem;
      color: #17252a;
    }
    .testimonial-list {
      display: grid;
      grid-template-columns: repeat(auto-fit,minmax(280px,1fr));
      gap: 2rem;
      max-width: 900px;
      margin: 0 auto;
    }
    .testimonial {
      background: white;
      padding: 1.5rem;
      border-radius: 8px;
      box-shadow: 0 3px 12px rgba(0,0,0,0.08);
      font-style: italic;
      position: relative;
    }
    .testimonial::before {
      content: "“";
      font-size: 3rem;
      color: #3aafa9;
      position: absolute;
      top: 10px;
      left: 15px;
    }
    .testimonial p {
      margin-bottom: 1rem;
    }
    .testimonial .author {
      font-weight: 700;
      color: #17252a;
      text-align: right;
    }

    /* Contact Section */
    .contact {
      background: white;
      padding: 2rem 2rem;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      max-width: 700px;
      margin: 0 auto 3rem auto;
    }
    .contact h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #17252a;
    }
    .contact form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    .contact label {
      font-weight: 600;
      color: #333;
    }
    .contact input, .contact textarea {
      padding: 0.8rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      resize: vertical;
    }
    .contact button {
      background: #3aafa9;
      border: none;
      color: white;
      padding: 1rem;
      border-radius: 8px;
      font-weight: 700;
      font-size: 1.1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    .contact button:hover {
      background: #2b7a78;
    }

    /* Footer */
    footer {
      text-align: center;
      padding: 1rem 0;
      background: #17252a;
      color: #def2f1;
      font-size: 0.9rem;
    }
    footer a {
      color: #def2f1;
      margin: 0 0.5rem;
      font-weight: 700;
    }
      nav {
    background: #2c3e50;
    padding: 10px 0;
  }
  nav ul {
    list-style: none;
    display: flex;
    justify-content: center;
    margin: 0;
    padding: 0;
  }
  nav ul li {
    margin: 0 15px;
  }
  nav ul li a {
    color: white;
    text-decoration: none;
    font-size: 16px;
    display: flex;
    align-items: center;
    transition: 0.3s;
  }
  nav ul li a i {
    margin-right: 6px;
    font-size: 18px;
  }
  nav ul li a:hover {
    color: #f39c12;
  }
  .button {
    background: #f39c12;
    padding: 6px 12px;
    border-radius: 5px;
  }
  .button:hover {
    background: #e67e22;
    color: white;
  }

  </style>
</head>
<body>

<header>
  <h1>Insurance Management System</h1>
<!-- Add this in <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<nav style="background: #222; padding: 10px 0;">
  <ul style="display: flex; justify-content: center; list-style: none; margin: 0; padding: 0;">
    
    <li style="margin: 0 15px;">
      <a href="#features" style="color: white; text-decoration: none; font-size: 16px;">
        <i class="fas fa-star"></i> Features
      </a>
    </li>

    <li style="margin: 0 15px;">
      <a href="#about" style="color: white; text-decoration: none; font-size: 16px;">
        <i class="fas fa-info-circle"></i> About
      </a>
    </li>

    <li style="margin: 0 15px;">
      <a href="#contact" style="color: white; text-decoration: none; font-size: 16px;">
        <i class="fas fa-envelope"></i> Contact
      </a>
    </li>

    <li style="margin: 0 15px;">
      <a href="user/login.php" style="background: #4CAF50; color: white; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 14px;">
        <i class="fas fa-user"></i> Login
      </a>
    </li>


    <li style="margin: 0 15px;">
      <a href="public/login.php" style="background: #f44336; color: white; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 14px;">
        <i class="fas fa-user-shield"></i>Login
      </a>
    </li>

  </ul>
</nav>
</header>

<main>
  <section class="hero">
    <h2>Manage Your Insurance Policies with Ease</h2>
    <p>Secure, Reliable, and User-Friendly Insurance Management System for Customers and Agents. Track policies, file claims, and get timely support — all in one place.</p>
    <a href="public/customers/add.php" class="btn-primary">Get Started</a>
  </section>

  <section id="features" class="features">
    <div class="feature-box">
      <h3>Policy Management</h3>
      <p>Easily view, add, and update insurance policies with all essential details stored securely.</p>
    </div>
    <div class="feature-box">
      <h3>Claims Tracking</h3>
      <p>Submit claims and monitor their status through a transparent, real-time dashboard.</p>
    </div>
    <div class="feature-box">
      <h3>Customer Portal</h3>
      <p>Secure login for customers to access personal information, policy details, and claims history.</p>
    </div>
    <div class="feature-box">
      <h3>Agent & Admin Control</h3>
      <p>Role-based access control for insurance agents and administrators to manage policies and claims.</p>
    </div>
    <div class="feature-box">
      <h3>Reports & Analytics</h3>
      <p>Generate reports for policy trends, claims processing time, and customer insights.</p>
    </div>
    <div class="feature-box">
      <h3>Secure & Compliant</h3>
      <p>Built with best security practices ensuring data privacy and compliance with industry regulations.</p>
    </div>
  </section>

  <section id="about" class="about">
    <h2>About Our System</h2>
    <p>Our Insurance Management System is designed to simplify the complex workflows of insurance companies by providing a centralized platform for managing policies, customers, and claims. Whether you're an individual policyholder or an insurance agent, our system offers seamless access to all relevant data, improving efficiency and customer satisfaction.</p>
  </section>

  <section id="testimonials" class="testimonials">
    <h2>What Our Users Say</h2>
    <div class="testimonial-list">
      <div class="testimonial">
        <p>This system made managing my insurance policies so much easier and transparent. Highly recommended!</p>
        <div class="author">— Riya Sharma, Customer</div>
      </div>
      <div class="testimonial">
        <p>Filing claims has never been smoother. The support team is prompt and helpful throughout the process.</p>
        <div class="author">— Amit Singh, Policyholder</div>
      </div>
      <div class="testimonial">
        <p>As an agent, this platform helps me track policies and claims efficiently. It has streamlined my workflow.</p>
        <div class="author">— Priya Mehta, Insurance Agent</div>
      </div>
    </div>
  </section>

  <section id="contact" class="contact">
    <h2>Contact Us</h2>
    <form method="post" action="/contact_submit.php">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" required />

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" required />

      <label for="message">Message</label>
      <textarea id="message" name="message" rows="5" required></textarea>

      <button type="submit">Send Message</button>
    </form>
  </section>
</main>

<footer>
  <p>© <?= date('Y') ?> Insurance Management System. All rights reserved.</p>
  <p>
    <a href="privacy_policy.php">Privacy Policy</a> | 
    <a href="term_of_service.php">Terms of Service</a> | 
    <a href="#contact">Contact</a>
  </p>
</footer>

</body>
</html>
