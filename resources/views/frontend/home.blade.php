<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GOParcel - Fast & Reliable Courier Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: #0d6efd;
            color: white;
            padding: 100px 0;
        }
        .footer {
            background: #333;
            color: white;
            padding: 20px 0;
        }
    </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero text-center">
    <div class="container">
        <h1 class="display-4">Welcome to GOParcel</h1>
        <p class="lead">Fast. Secure. On-Time Delivery Every Time.</p>
        <a href="#services" class="btn btn-light mt-3">Explore Services</a>
    </div>
</section>

<!-- About Section -->
<section class="py-5" id="about">
    <div class="container text-center">
        <h2>About Us</h2>
        <p class="mt-3">GOParcel is your trusted delivery partner, offering lightning-fast courier services across the country. Our mission is simple: safe, speedy, and seamless delivery at your fingertips.</p>
    </div>
</section>

<!-- Services Section -->
<section class="bg-light py-5" id="services">
    <div class="container text-center">
        <h2>Our Services</h2>
        <div class="row mt-4">
            <div class="col-md-4">
                <h5>Same-Day Delivery</h5>
                <p>Need it now? We'll get it there today.</p>
            </div>
            <div class="col-md-4">
                <h5>Standard Delivery</h5>
                <p>Reliable delivery within 1-3 business days.</p>
            </div>
            <div class="col-md-4">
                <h5>International Shipping</h5>
                <p>Send parcels globally with full tracking and care.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form -->
<section class="py-5" id="contact">
    <div class="container">
        <h2 class="text-center">Contact Us</h2>
        <form class="mt-4 mx-auto" style="max-width: 600px;">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" placeholder="Your Name">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="you@example.com">
            </div>
            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea class="form-control" rows="4" placeholder="How can we help?"></textarea>
            </div>
            <button class="btn btn-primary">Send Message</button>
        </form>
    </div>
</section>

<!-- Footer -->
<footer class="footer text-center">
    <div class="container">
        <p>&copy; {{ date('Y') }} GOParcel. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
