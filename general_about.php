<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <link rel="stylesheet" href="general_about.css" />
</head>
<body>
  <!-- HEADER -->
  <header>
    <!-- Logo outside navbar -->
    <a href="homepage.php" class="logo">
      <img src="Images/home-icon3.png" alt="Home" class="home-icon">
    </a>

    <!-- Mobile Menu -->
    <div class="mobile-menu">
      <nav class="mobile-nav">
        <a href="login.php">LOGIN/SIGN UP</a>
        <a href="general_about.php">ABOUT US</a>
        <a href="general_services.php">SERVICES</a>
        <a href="general-contact-us.php">CONTACT US</a>
      </nav>
      <button class="menu-button">☰</button>
    </div>

    <!-- Desktop Nav -->
    <nav class="desktop-nav">
      <a href="login.php">LOGIN/SIGN UP</a>
      <a href="general_about.php">ABOUT US</a>
      <a href="general_services.php">SERVICES</a>
      <a href="general-contact-us.php">CONTACT US</a>
    </nav>
  </header>

  <h1 class="about-title">About Our Church</h1>

  <div class="about-container">

    <!-- Left Column -->
    <div class="about-left">
      <div class="about-item">
        <img src="Images/churchfront.jpg" alt="Church History">
        <div>
          <h3>Church History</h3>
          <p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sequi maiores ipsa odit deleniti aperiam. Tempore voluptatum impedit architecto ab voluptate corporis, repellat consequuntur quis, beatae quidem voluptatibus quod accusantium voluptatem voluptas dolore aspernatur quaerat incidunt eum perferendis quae recusandae odit?
          </p>
        </div>
      </div>

      <div class="about-item">
        <img src="Images/fire.jpg" alt="Mission and Beliefs">
        <div>
          <h3>Mission & Beliefs</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo voluptatum voluptatibus nobis ipsam exercitationem accusamus veritatis explicabo minima, labore minus suscipit blanditiis pariatur laboriosam eos nostrum quia accusantium quis maiores voluptates error assumenda sunt iste! Consequuntur nisi praesentium autem similique!
          </p>
        </div>
      </div>

      <div class="about-item">
        <img src="Images/clergy.jpg" alt="Priest Biographies">
        <div>
          <h3>Priest Biographies</h3>
          <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate, molestiae minima fugit dignissimos blanditiis laboriosam reprehenderit alias explicabo esse sed aut voluptates, laborum officiis nam quas veniam omnis animi deserunt et magni! Consectetur possimus eum dolorem rem ipsa explicabo ipsam?
          </p>
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div class="about-right">
      <a href="https://www.google.com/maps/place/Saint+Gebriel+Eth%2FErt+Orthodox+Church+Kigali/@-1.9661295,30.0982874,17z/data=!3m1!4b1!4m6!3m5!1s0x19dca7b8c36059c5:0xbbe333d948245ee0!8m2!3d-1.9661295!4d30.1008623!16s%2Fg%2F11h_60nwlh?entry=ttu&g_ep=EgoyMDI1MDkyMS4wIKXMDSoASAFQAw%3D%3D" target="_blank">
        <img src="Images/map.jpg" alt="Church Map" class="map-img">
      </a>

      <div class="contact-info">
        <p><strong>Address:</strong> <span>KG 654 St, Kigali</span></p>
        <p><strong>Phone Number:</strong> <span>+250 xxx xxx xxx</span></p>
        <p><strong>Opening Hours:</strong> <span>Mon–Sun, 8:00–18:00</span></p>
      </div>
    </div>
  </div>
</body>
</html>
