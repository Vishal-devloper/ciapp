<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="<?php echo base_url('public/admin/css/user.css') ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
</head>
<body>
  <div class="wrapper">
    <form id="loginForm" action="<?php echo site_url('public/admin/User/ajaxLogin') ?>" method="post">
      <?= csrf_field() ?>
      <h2>Login</h2>
        <div class="input-field">
        <input type="text" name="email" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" name="password" class="loginPassword" required>
        <label>Enter your password</label>
      </div>
      <div class="forget">
        <label for="remember">
          <input type="checkbox" id="remember">
          <p>Remember me</p>
        </label>
        <a href="#">Forgot password?</a>
      </div>
      <button type="submit">Log In</button>
      <div class="register">
        <p>Don't have an account? <a href="<?php echo base_url('public/admin/register') ?>">Register</a></p>
      </div>
    </form>
  </div>
  <script>
    const ajaxRequestUrlLogin ="<?= site_url('public/admin/User/ajaxLogin') ?>";
  </script>
  <script src="<?= base_url('public/admin/js/validation.js') ?>"></script>
</body>
</html>