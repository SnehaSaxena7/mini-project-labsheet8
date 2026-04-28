<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Golden Crust Bakery - Fresh breads, cakes, coffee, cookies, and table booking." />
  <title>Golden Crust Bakery</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Cormorant+Garamond:wght@500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <header class="site-header">
    <nav class="navbar">
      <a class="logo" href="#">Golden Crust</a>
      <ul class="nav-links">
        <li><a href="#">Home</a></li>
        <li><a href="#menu">Menu</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#booking">Book a Seat</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="hero">
      <div class="hero-text">
        <p class="eyebrow">Fresh Bakery & Coffee</p>
        <h1>Freshly Baked <span>Happiness</span></h1>
        <p>Artisan breads, handcrafted cakes, and premium coffee served with love every day.</p>
        <a class="btn" href="#menu">Explore Menu</a>
      </div>

      <div class="hero-img">
        <img src="images/hero.jpg" alt="Fresh bakery items on display" loading="lazy">
      </div>
    </section>

    <section class="menu" id="menu">
      <h2>Our Menu</h2>
      <p class="section-subtitle">Handmade treats prepared fresh daily.</p>

      <div class="menu-grid">
        <article class="card">
          <img src="images/bread.jpg" alt="Fresh bread" loading="lazy">
          <h3>Fresh Bread</h3>
          <p>Soft, warm, and baked fresh every morning.</p>
          <span>₹120</span>
        </article>

        <article class="card">
          <img src="images/cake.jpg" alt="Cream cake" loading="lazy">
          <h3>Cake</h3>
          <p>Delicious creamy cakes for every celebration.</p>
          <span>₹350</span>
        </article>

        <article class="card">
          <img src="images/coffee.jpg" alt="Cup of coffee" loading="lazy">
          <h3>Coffee</h3>
          <p>Premium roasted coffee made to perfection.</p>
          <span>₹180</span>
        </article>

        <article class="card">
          <img src="images/cookies.jpg" alt="Fresh cookies" loading="lazy">
          <h3>Cookies</h3>
          <p>Crunchy, sweet, and perfect with tea.</p>
          <span>₹90</span>
        </article>
      </div>
    </section>

    <section class="about" id="about">
      <div class="about-img">
        <img src="images/shop.jpg" alt="Golden Crust Bakery shop interior" loading="lazy">
      </div>

      <div class="about-text">
        <h2>About Us</h2>
        <p>
          Golden Crust Bakery is built on a love for fresh ingredients, authentic recipes, and warm hospitality.
          We believe every bite should feel special and every visit should feel welcoming.
        </p>
      </div>
    </section>

    <section class="booking" id="booking">
      <h2>Book a Seat</h2>
      <p class="section-subtitle">Reserve your table before visiting us.</p>

      <form class="booking-form" action="booking.php" method="post">
        <label for="bname">Your Name</label>
        <input id="bname" name="bname" type="text" placeholder="Enter your name" />

        <label for="bphone">Phone Number</label>
        <input id="bphone" name="bphone" type="tel" placeholder="Enter your phone number" />

        <label for="date">Booking Date</label>
        <input id="date" name="date" type="date" />

        <label for="time">Booking Time</label>
        <input id="time" name="time" type="time" />

        <label for="seats">Number of Seats</label>
        <select id="seats" name="seats">
          <option value="">Select seats</option>
          <option value="1">1 Seat</option>
          <option value="2">2 Seats</option>
          <option value="3">3 Seats</option>
          <option value="4">4 Seats</option>
          <option value="5">5 Seats</option>
          <option value="6+">6+ Seats</option>
        </select>

        <label>Seating Preference</label>
        <div class="radio-group">
          <label><input type="radio" name="seat" value="indoor"> Indoor</label>
          <label><input type="radio" name="seat" value="outdoor"> Outdoor</label>
          <label><input type="radio" name="seat" value="window"> Window Side</label>
        </div>

        <label for="note">Special Request</label>
        <textarea id="note" name="note" placeholder="Any special request?"></textarea>

        <button type="submit" class="btn">Book Now</button>
      </form>
    </section>

    <section class="contact" id="contact">
      <h2>Contact Us</h2>

      <form class="contact-form" action="contact.php" method="post">
        <label for="name">Your Name</label>
        <input id="name" name="name" type="text" placeholder="Enter your name" />

        <label for="email">Your Email</label>
        <input id="email" name="email" type="email" placeholder="Enter your email" />

        <label for="message">Message</label>
        <textarea id="message" name="message" placeholder="Write your message"></textarea>

        <button type="submit" class="btn">Send Message</button>
      </form>
    </section>
  </main>

  <footer class="footer">
    <p>© 2026 Golden Crust Bakery | All Rights Reserved</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>