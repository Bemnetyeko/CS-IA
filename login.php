<?php
session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'signup' => $_SESSION['signup_error'] ?? '',
];
$activeForm = $_SESSION['active_form'] ?? 'login';

function isActiveForm($formName, $activeForm) {
    return $formName == $activeForm ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login / Sign Up</title>
<link rel="stylesheet" href="loginstyle.css">
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

<div class="container">

  <!-- LOGIN -->
  <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
    <form action="login_register.php" method="post">
      <h2>Login</h2>
      <p class="error-message" id="login-error"><?= $errors['login']; ?></p>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Login</button>
    </form>
  </div>

  <!-- SIGN UP -->
  <div class="form-box <?= isActiveForm('signup', $activeForm); ?>" id="signup-form">
    <form action="login_register.php" method="post">
      <h2>Sign Up</h2>
      <p class="error-message" id="signup-error"><?= $errors['signup']; ?></p>
      <input type="text" name="name" placeholder="Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <select name="role" required>
        <option value="">--Select Role--</option>
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>
      <button type="submit" name="signup">Sign Up</button>
    </form>
  </div>

</div>

</body>
</html>

<?php
// clear session after page rendered
session_unset();
?>
